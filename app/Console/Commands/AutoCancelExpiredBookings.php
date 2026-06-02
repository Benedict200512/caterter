<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Notifications\AppNotification;
use Carbon\Carbon;

class AutoCancelExpiredBookings extends Command
{
    protected $signature = 'bookings:auto-cancel';
    protected $description = 'Auto-cancel bookings where downpayment deadline has passed without verified payment';

    public function handle(): int
    {
        $expiredBookings = Booking::whereNotNull('downpayment_deadline')
            ->where('downpayment_deadline', '<', Carbon::today())
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('status', 'confirmed')
                      ->whereIn('payment_status', ['unpaid', 'rejected']);
                })
                ->orWhere(function ($q) {
                    $q->where('status', 'awaiting_payment')
                      ->where('payment_status', 'submitted');
                });
            })
            ->with(['user', 'catererProfile.user'])
            ->get();

        $count = 0;

        foreach ($expiredBookings as $booking) {

            $wasAwaiting = $booking->status === 'awaiting_payment';

            $reason = $wasAwaiting
                ? 'Booking automatically cancelled — payment receipt was not verified before the deadline (' . $booking->downpayment_deadline->format('M d, Y') . ').'
                : 'Booking automatically cancelled due to non-payment of 50% downpayment before the deadline (' . $booking->downpayment_deadline->format('M d, Y') . ').';

            $booking->update([
                'status'            => 'cancelled',
                'rejection_reason'  => $reason,
                'cancellation_type' => 'auto_deadline',
                'auto_cancelled_at' => now(),
            ]);

            if ($booking->user) {
                $booking->user->notify(new AppNotification([
                    'title'   => 'Booking Auto-Cancelled',
                    'message' => $reason,
                    'url'     => route('bookings.show', $booking->id),
                    'type'    => 'danger',
                ]));
            }

            if ($booking->catererProfile && $booking->catererProfile->user) {
                $booking->catererProfile->user->notify(new AppNotification([
                    'title'   => 'Booking Auto-Cancelled (Deadline Passed)',
                    'message' => 'Booking by ' . ($booking->user->name ?? 'customer') . ' for ' . $booking->event_date->format('M d, Y') . ' was auto-cancelled — downpayment deadline passed.',
                    'url'     => route('bookings.show', $booking->id),
                    'type'    => 'warning',
                ]));
            }

            $count++;
        }

        $this->info("Auto-cancelled {$count} expired booking(s).");

        return Command::SUCCESS;
    }
}