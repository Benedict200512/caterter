<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FIX #2: Add missing columns that BookingController uses but don't exist in the database.
     *
     * Columns added:
     * - rejection_reason (used in BookingController::update when rejecting)
     * - payment_methods  (used in BookingController::update when confirming)
     *
     * Columns already in DB but missing from Booking model $fillable:
     * - downpayment_amount, downpayment_deadline, downpayment_paid
     * (These are fixed in the Booking model, not here)
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Only add if they don't already exist
            if (!Schema::hasColumn('bookings', 'rejection_reason')) {
                $table->string('rejection_reason', 500)->nullable()->after('status');
            }
            if (!Schema::hasColumn('bookings', 'payment_methods')) {
                $table->json('payment_methods')->nullable()->after('downpayment_paid');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['rejection_reason', 'payment_methods']);
        });
    }
};