<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Message;
use App\Notifications\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class ChatController extends Controller
{
    /**
     * Store and send a chat message with notification support.
     * * @param  Request  $request
     * @param  int  $id (Booking ID)
     * @return RedirectResponse
     */
    public function store(Request $request, $id): RedirectResponse
    {
        // 1. VALIDATION
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // 2. RETRIEVAL & AUTHORIZATION
        // We eager load relationships to avoid multiple database hits
        $booking = Booking::with(['user', 'catererProfile.user'])->findOrFail($id);
        $user = Auth::user();

        $isCustomer = (int) $booking->user_id === (int) $user->id;
        $isCaterer = $user->catererProfile && (int) $booking->caterer_profile_id === (int) $user->catererProfile->id;

        if (!$isCustomer && !$isCaterer) {
            abort(403, 'Unauthorized: You are not a participant in this booking.');
        }

        // 3. DATABASE TRANSACTION
        // Ensures that the message is only saved if the notification logic doesn't crash
        DB::transaction(function () use ($request, $booking, $user, $isCustomer) {
            
            // Create the message record
            Message::create([
                'booking_id' => $booking->id,
                'sender_id'   => $user->id,
                'message'     => strip_tags($request->message), // Basic sanitization
                'is_read'     => false,
            ]);

            // 4. NOTIFICATION LOGIC
            // If the sender is the customer, notify the caterer user. Otherwise, notify the customer.
            $recipient = $isCustomer ? $booking->catererProfile->user : $booking->user;

            if ($recipient) {
                $recipient->notify(new AppNotification([
                    'title'   => 'New Message',
                    'message' => "{$user->name} sent a message regarding the booking on {$booking->event_date}",
                    'url'     => route('bookings.show', $booking->id),
                    'type'    => 'info'
                ]));
            }
        });

        return back()->with('success', 'Message sent successfully.');
    }
}