<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * BATCH B: Payment Flow Migration
     * 
     * Adds columns for:
     * - Payment receipt upload (proof of payment)
     * - Payment status tracking (pending, submitted, verified, rejected)
     * - Which payment method the customer actually used
     * - When caterer verified the payment
     * - Auto-cancellation timestamp and reason
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'payment_receipt_path')) {
                $table->string('payment_receipt_path', 500)->nullable()->after('payment_methods');
            }
            if (!Schema::hasColumn('bookings', 'payment_method_used')) {
                $table->string('payment_method_used', 50)->nullable()->after('payment_receipt_path');
            }
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->string('payment_status', 30)->default('unpaid')->after('payment_method_used');
                // Values: unpaid, submitted, verified, rejected
            }
            if (!Schema::hasColumn('bookings', 'payment_verified_at')) {
                $table->timestamp('payment_verified_at')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('bookings', 'payment_rejection_reason')) {
                $table->string('payment_rejection_reason', 500)->nullable()->after('payment_verified_at');
            }
            if (!Schema::hasColumn('bookings', 'auto_cancelled_at')) {
                $table->timestamp('auto_cancelled_at')->nullable()->after('payment_rejection_reason');
            }
            if (!Schema::hasColumn('bookings', 'cancellation_type')) {
                $table->string('cancellation_type', 30)->nullable()->after('auto_cancelled_at');
                // Values: manual, auto_deadline, auto_payment_rejected
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_receipt_path',
                'payment_method_used',
                'payment_status',
                'payment_verified_at',
                'payment_rejection_reason',
                'auto_cancelled_at',
                'cancellation_type',
            ]);
        });
    }
};