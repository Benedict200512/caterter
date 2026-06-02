<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Review;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FINAL — BOOKING STATUS LIFECYCLE (Batch B + C merged)
    |--------------------------------------------------------------------------
    |
    | Status Flow:
    |   pending → confirmed → (customer uploads receipt) → awaiting_payment
    |           → (caterer verifies) → paid → completed
    |
    | Alternate paths:
    |   pending → rejected (by caterer)
    |   pending/confirmed → cancelled (by customer)
    |   confirmed → cancelled (auto — deadline passed, no payment)
    |   awaiting_payment → confirmed (caterer rejects receipt — customer retries)
    |   awaiting_payment → cancelled (auto — deadline passed, unverified)
    |
    |--------------------------------------------------------------------------
    */

    public function apiCheckAvailability(Request $request): JsonResponse
    {
        if (!$request->has(['caterer_id', 'date'])) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }
        $isFullyBooked = Booking::where('caterer_profile_id', (int)$request->caterer_id)
            ->where('event_date', $request->date)
            ->whereIn('status', ['confirmed', 'awaiting_payment', 'paid'])
            ->exists();
        return response()->json(['available' => !$isFullyBooked]);
    }

    public function show($id): View
    {
        $booking = Booking::with(['user', 'catererProfile.user', 'messages', 'package'])->findOrFail((int)$id);
        $user    = Auth::user();

        $isCustomer = (int)$booking->user_id === (int)$user->id;
        $isCaterer  = $user->catererProfile && (int)$booking->caterer_profile_id === (int)$user->catererProfile->id;

        if (!$isCustomer && !$isCaterer) {
            abort(403, 'Unauthorized access.');
        }

        $booking->messages()
            ->where('sender_id', '!=', (int)$user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $pastBookings    = collect();
        $customerStats   = ['total_bookings' => 0, 'completed' => 0];
        $customerReviews = collect();

        if ($isCaterer) {
            $pastBookings = Booking::where('user_id', $booking->user_id)
                ->where('caterer_profile_id', $booking->caterer_profile_id)
                ->orderBy('event_date', 'desc')
                ->get();

            $customerStats = [
                'total_bookings' => $pastBookings->count(),
                'completed'      => $pastBookings->where('status', 'completed')->count(),
            ];

            $customerReviews = Review::where('user_id', $booking->user_id)
                ->where('caterer_profile_id', $booking->caterer_profile_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('caterer.bookings.show', compact(
            'booking', 'pastBookings', 'customerStats', 'customerReviews', 'isCustomer', 'isCaterer'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->role === 'admin') {
            return back()->with('error', 'Admins cannot place orders.');
        }

        $request->validate([
    'caterer_profile_id'   => 'required|exists:caterer_profiles,id',
    'event_date'           => [
        'required',
        'date',
        'after:today',
    ],
    'event_time'           => 'nullable|date_format:H:i',
    'pax'                  => 'required|integer|min:1',
    'event_type'           => 'nullable|string|max:100',
    'event_location'       => 'nullable|string|max:255',
    'dietary_requirements' => 'nullable|string|max:255',
    'notes'                => 'nullable|string|max:1000',
], [
    'event_date.after' => 'Event date must be at least tomorrow or later.',
]);

        return DB::transaction(function () use ($request) {
            $booking = Booking::create([
                'user_id'               => (int)Auth::id(),
                'caterer_profile_id'    => (int)$request->caterer_profile_id,
                'event_date'            => $request->event_date,
                'event_time'            => $request->event_time,
                'pax'                   => (int)$request->pax,
                'event_type'            => $request->event_type,
                'event_location'        => $request->event_location,
                'dietary_requirements'  => $request->dietary_requirements,
                'notes'                 => $request->notes,
                'status'                => 'pending',
                'payment_status'        => 'unpaid',
                'selected_package_id'   => $request->input('selected_package_id'),
                'selected_package_name' => $request->input('selected_package_name'),
                'selected_menu_ids'     => $request->input('selected_menu_ids'),
                'estimated_total'       => $request->input('estimated_total'),
            ]);

            $booking->catererProfile->user->notify(new AppNotification([
                'title'   => 'New Inquiry',
                'message' => 'New booking request for ' . Carbon::parse($booking->event_date)->format('M d, Y'),
                'url'     => route('bookings.show', $booking->id),
                'type'    => 'info',
            ]));

            return redirect('/dashboard')->with('success', 'Inquiry sent successfully!');
        });
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $booking        = Booking::findOrFail((int)$id);
        $user           = Auth::user();
        $catererProfile = $user->catererProfile;

        if (!$catererProfile || (int)$catererProfile->id !== (int)$booking->caterer_profile_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status'               => 'required|in:confirmed,rejected,completed',
            'rejection_reason'     => 'required_if:status,rejected|nullable|string|max:255',
            'custom_reason'        => 'nullable|string|max:500',
            'downpayment_deadline' => 'required_if:status,confirmed|nullable|date|after:today',
            'payment_methods'      => 'required_if:status,confirmed|nullable|array|min:1',
            'payment_methods.*'    => 'string|in:gcash,maya,bank_transfer,credit_card,cash,online_transfer',
        ]);

        try {
            return DB::transaction(function () use ($request, $booking) {

                $status      = $request->status;
                $message     = 'Booking status updated successfully.';
                $notifyTitle = 'Booking Update';
                $notifyType  = 'info';

                // ─── CONFIRM ───────────────────────────────────
                if ($status === 'confirmed') {

                if ($request->gcash_number) {
    auth()->user()->catererProfile->update(['gcash_number' => $request->gcash_number]);
}
if ($request->hasFile('gcash_qr_code')) {
    $path = $request->file('gcash_qr_code')->store('gcash_qr', 'public');
    auth()->user()->catererProfile->update(['gcash_qr_path' => $path]);
}

                    if ($booking->status !== 'pending') {
                        return redirect()->back()->with('error', 'Only pending bookings can be confirmed.');
                    }

                    $conflictExists = Booking::where('caterer_profile_id', $booking->caterer_profile_id)
                        ->where('event_date', $booking->event_date)
                        ->whereIn('status', ['confirmed', 'awaiting_payment', 'paid'])
                        ->where('id', '!=', $booking->id)
                        ->exists();

                    if ($conflictExists) {
                        return redirect()->back()
                            ->with('error', 'A confirmed booking already exists for this date.');
                    }

                    Booking::where('caterer_profile_id', (int)$booking->caterer_profile_id)
                        ->where('event_date', $booking->event_date)
                        ->where('status', 'pending')
                        ->where('id', '!=', (int)$booking->id)
                        ->get()
                        ->each(function ($otherBooking) {
                            $otherBooking->update([
                                'status'           => 'rejected',
                                'rejection_reason' => 'The caterer accepted another booking for this date.',
                            ]);
                            $otherBooking->user->notify(new AppNotification([
                                'title'   => 'Booking Rejected',
                                'message' => 'Your booking for ' . $otherBooking->event_date->format('M d, Y') . ' was declined — the caterer accepted another inquiry for this date.',
                                'url'     => route('bookings.show', $otherBooking->id),
                                'type'    => 'danger',
                            ]));
                        });

                    $downpaymentAmount = $booking->estimated_total
                        ? round($booking->estimated_total * 0.5, 2)
                        : null;

                    $booking->update([
                        'status'               => 'confirmed',
                        'rejection_reason'     => null,
                        'downpayment_deadline' => $request->downpayment_deadline,
                        'downpayment_amount'   => $downpaymentAmount,
                        'payment_methods'      => $request->payment_methods,
                        'payment_status'       => 'unpaid',
                    ]);

                    $notifyTitle = 'Booking Confirmed — Payment Required';
                    $notifyType  = 'success';
                    $message     = 'Booking confirmed. The customer has been notified to pay the 50% downpayment.';

                    
                // ─── REJECT ────────────────────────────────────
                } elseif ($status === 'rejected') {

                    if ($booking->status !== 'pending') {
                        return redirect()->back()->with('error', 'Only pending bookings can be rejected.');
                    }

                    $finalReason = $request->rejection_reason ?? 'No reason provided';
                    if ($request->custom_reason) {
                        $finalReason .= ': ' . $request->custom_reason;
                    }

                    $booking->update([
                        'status'           => 'rejected',
                        'rejection_reason' => $finalReason,
                    ]);

                    $notifyTitle = 'Booking Rejected';
                    $notifyType  = 'danger';
                    $message     = 'The inquiry has been rejected.';

                // ─── COMPLETE ──────────────────────────────────
                } elseif ($status === 'completed') {

                    if ($booking->status !== 'paid') {
                        return redirect()->back()
                            ->with('error', 'Only paid bookings can be marked as completed. Current status: ' . ucfirst($booking->status));
                    }

                    $booking->update(['status' => 'completed']);

                    $notifyTitle = 'Event Completed!';
                    $notifyType  = 'success';
                    $message     = 'Event marked as completed. The customer can now leave a review.';
                }

                $notifyMessage = match($status) {
                    'confirmed' => 'Your booking for ' . $booking->event_date->format('M d, Y') . ' has been confirmed! Please pay the 50% downpayment (₱' . number_format($booking->downpayment_amount ?? 0, 2) . ') by ' . ($booking->downpayment_deadline ? $booking->downpayment_deadline->format('M d, Y') : 'the deadline') . '.',
                    'rejected'  => 'Your booking for ' . $booking->event_date->format('M d, Y') . ' has been declined.',
                    'completed' => 'Your event on ' . $booking->event_date->format('M d, Y') . ' has been marked as completed. We\'d love to hear your feedback!',
                    default     => 'Your booking has been updated.',
                };

                $booking->user->notify(new AppNotification([
                    'title'   => $notifyTitle,
                    'message' => $notifyMessage,
                    'url'     => route('bookings.show', $booking->id),
                    'type'    => $notifyType,
                ]));

                return redirect()->route('bookings.show', $booking->id)
                    ->with('success', $message);
            });

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Customer uploads payment receipt.
     * Transition: confirmed → awaiting_payment
     */
    public function uploadPayment(Request $request, $id): RedirectResponse
    {
        $booking = Booking::findOrFail((int)$id);
        $user    = Auth::user();

        if ((int)$booking->user_id !== (int)$user->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Payment can only be submitted for confirmed bookings.');
        }

        if ($booking->payment_status === 'verified') {
            return back()->with('error', 'Payment has already been verified.');
        }

        if ($booking->isDeadlinePassed()) {
            return back()->with('error', 'The downpayment deadline has passed. This booking may be cancelled.');
        }

        $request->validate([
            'payment_method_used' => 'required|string|max:50',
            'payment_receipt'     => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'payment_method_used.required' => 'Please select your payment method.',
            'payment_receipt.required'     => 'Please upload your proof of payment.',
            'payment_receipt.image'        => 'The file must be an image (JPG, PNG).',
            'payment_receipt.max'          => 'Receipt image must not exceed 5MB.',
        ]);

        if ($booking->payment_receipt_path) {
            Storage::disk('public')->delete($booking->payment_receipt_path);
        }

        $receiptPath = $request->file('payment_receipt')->store('payment_receipts', 'public');

        $booking->update([
            'payment_receipt_path'     => $receiptPath,
            'payment_method_used'      => $request->payment_method_used,
            'payment_status'           => 'submitted',
            'payment_rejection_reason' => null,
            'status'                   => 'awaiting_payment',
        ]);

        $booking->catererProfile->user->notify(new AppNotification([
            'title'   => 'Payment Receipt Submitted',
            'message' => $user->name . ' has uploaded a downpayment receipt for ' . $booking->event_date->format('M d, Y') . '. Please verify.',
            'url'     => route('bookings.show', $booking->id),
            'type'    => 'warning',
        ]));

        return back()->with('success', 'Payment receipt submitted! The caterer will verify your payment shortly.');
    }

    /**
     * Caterer verifies the payment receipt.
     * Transition: awaiting_payment → paid
     */
    public function verifyPayment($id): RedirectResponse
    {
        $booking        = Booking::findOrFail((int)$id);
        $user           = Auth::user();
        $catererProfile = $user->catererProfile;

        if (!$catererProfile || (int)$catererProfile->id !== (int)$booking->caterer_profile_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'awaiting_payment' || $booking->payment_status !== 'submitted') {
            return back()->with('error', 'No payment receipt to verify.');
        }

        $booking->update([
            'status'              => 'paid',
            'payment_status'      => 'verified',
            'payment_verified_at' => now(),
            'downpayment_paid'    => true,
        ]);

        $booking->user->notify(new AppNotification([
            'title'   => 'Payment Verified — Booking Secured!',
            'message' => 'Your downpayment for ' . $booking->event_date->format('M d, Y') . ' has been confirmed. Your booking is now fully secured!',
            'url'     => route('bookings.show', $booking->id),
            'type'    => 'success',
        ]));

        return back()->with('success', 'Payment verified. Booking is now fully secured.');
    }

    /**
     * Caterer rejects the payment receipt.
     * Transition: awaiting_payment → confirmed (customer can re-upload)
     */
    public function rejectPayment(Request $request, $id): RedirectResponse
    {
        $booking        = Booking::findOrFail((int)$id);
        $user           = Auth::user();
        $catererProfile = $user->catererProfile;

        if (!$catererProfile || (int)$catererProfile->id !== (int)$booking->caterer_profile_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'awaiting_payment' || $booking->payment_status !== 'submitted') {
            return back()->with('error', 'No payment receipt to reject.');
        }

        $request->validate([
            'payment_rejection_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status'                   => 'confirmed',
            'payment_status'           => 'rejected',
            'payment_rejection_reason' => $request->payment_rejection_reason,
        ]);

        $booking->user->notify(new AppNotification([
            'title'   => 'Payment Receipt Rejected',
            'message' => 'Your payment receipt was not accepted. Reason: ' . $request->payment_rejection_reason . '. Please upload a new receipt before the deadline.',
            'url'     => route('bookings.show', $booking->id),
            'type'    => 'danger',
        ]));

        return back()->with('success', 'Payment receipt rejected. The customer has been notified to re-upload.');
    }

    /**
     * Customer cancellation.
     * Allowed from: pending, confirmed
     */
    public function cancel(Request $request, $id): RedirectResponse
    {
        $booking = Booking::findOrFail((int)$id);
        $user    = Auth::user();

        if ((int)$booking->user_id !== (int)$user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This booking cannot be cancelled. Current status: ' . ucfirst($booking->status));
        }

        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $reason = $request->cancellation_reason ?? 'Cancelled by customer';

        $booking->update([
            'status'            => 'cancelled',
            'rejection_reason'  => $reason,
            'cancellation_type' => 'manual',
        ]);

        $booking->catererProfile->user->notify(new AppNotification([
            'title'   => 'Booking Cancelled',
            'message' => $user->name . ' cancelled their booking for ' . $booking->event_date->format('M d, Y') . '.',
            'url'     => route('bookings.show', $booking->id),
            'type'    => 'warning',
        ]));

        return redirect()->route('dashboard')->with('success', 'Your booking has been cancelled.');
    }

    /**
     * Manual downpayment toggle (backward compat).
     */
    public function markDownpaymentPaid(Request $request, $id): RedirectResponse
    {
        $booking        = Booking::findOrFail((int)$id);
        $user           = Auth::user();
        $catererProfile = $user->catererProfile;

        if (!$catererProfile || (int)$catererProfile->id !== (int)$booking->caterer_profile_id) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($booking->status, ['confirmed', 'paid'])) {
            return back()->with('error', 'Cannot toggle downpayment for this booking status.');
        }

        $nowPaid = !$booking->downpayment_paid;

        $booking->update([
            'downpayment_paid'    => $nowPaid,
            'payment_status'      => $nowPaid ? 'verified' : 'unpaid',
            'payment_verified_at' => $nowPaid ? now() : null,
            'status'              => $nowPaid ? 'paid' : 'confirmed',
        ]);

        $statusText = $nowPaid ? 'received' : 'unmarked';

        $booking->user->notify(new AppNotification([
            'title'   => 'Downpayment ' . ucfirst($statusText),
            'message' => 'Your downpayment for ' . $booking->event_date->format('M d, Y') . ' has been ' . $statusText . '.',
            'url'     => route('bookings.show', $booking->id),
            'type'    => $nowPaid ? 'success' : 'info',
        ]));

        return back()->with('success', 'Downpayment marked as ' . $statusText . '.');
    }

    public function getCalendarEvents(): JsonResponse
    {
        $user = Auth::user();
        if (!$user->catererProfile) {
            return response()->json([]);
        }

        $bookings = Booking::where('caterer_profile_id', (int)$user->catererProfile->id)
            ->whereIn('status', ['confirmed', 'awaiting_payment', 'paid', 'completed'])
            ->get()
            ->map(fn($b) => [
                'id'              => (int)$b->id,
                'title'           => match($b->status) {
                    'completed'        => '✔ PAX: ' . (int)$b->pax,
                    'paid'             => '💰 PAX: ' . (int)$b->pax,
                    'awaiting_payment' => '⏳ PAX: ' . (int)$b->pax,
                    default            => 'PAX: ' . (int)$b->pax,
                },
                'start'           => $b->event_date->toDateString(),
                'backgroundColor' => match($b->status) {
                    'completed'        => '#6c757d',
                    'paid'             => '#059669',
                    'awaiting_payment' => '#2563eb',
                    default            => '#FF7A00',
                },
                'borderColor'     => match($b->status) {
                    'completed'        => '#6c757d',
                    'paid'             => '#059669',
                    'awaiting_payment' => '#2563eb',
                    default            => '#FF7A00',
                },
                'url'             => route('bookings.show', $b->id),
            ]);

        return response()->json($bookings);
    }
}