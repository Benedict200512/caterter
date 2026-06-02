<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // ── Event details (missing from original migration) ──────────────
            $table->time('event_time')->nullable()->after('event_date');
            $table->string('event_type')->nullable()->after('event_time');
            $table->string('event_location')->nullable()->after('event_type');
            $table->string('dietary_requirements')->nullable()->after('event_location');
            $table->text('notes')->nullable()->after('dietary_requirements');

            // ── Package & menu selection ──────────────────────────────────────
            // The package the customer selected from the caterer's package list
            $table->unsignedBigInteger('selected_package_id')->nullable()->after('notes');
            $table->foreign('selected_package_id')
                  ->references('id')
                  ->on('packages')   // adjust table name if yours differs
                  ->nullOnDelete();

            // Snapshot of the package name at time of booking (in case it changes later)
            $table->string('selected_package_name')->nullable()->after('selected_package_id');

            // Comma-separated IDs of the individual menu add-ons the customer picked
            // e.g. "3,7,12"
            $table->text('selected_menu_ids')->nullable()->after('selected_package_name');

            // ── Budget / payment ──────────────────────────────────────────────
            // The live estimate the customer saw when they submitted the booking
            $table->decimal('estimated_total', 10, 2)->nullable()->after('selected_menu_ids');

            // Downpayment tracking
            $table->decimal('downpayment_amount', 10, 2)->nullable()->after('estimated_total');
            $table->date('downpayment_deadline')->nullable()->after('downpayment_amount');
            $table->boolean('downpayment_paid')->default(false)->after('downpayment_deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign key first, then columns
            $table->dropForeign(['selected_package_id']);

            $table->dropColumn([
                'event_time',
                'event_type',
                'event_location',
                'dietary_requirements',
                'notes',
                'selected_package_id',
                'selected_package_name',
                'selected_menu_ids',
                'estimated_total',
                'downpayment_amount',
                'downpayment_deadline',
                'downpayment_paid',
            ]);
        });
    }
};