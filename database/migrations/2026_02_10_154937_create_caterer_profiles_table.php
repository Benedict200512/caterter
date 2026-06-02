<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caterer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ── Business Information ───────────────────────────────────
            $table->string('business_name');
            $table->string('contact_number', 20)->nullable();
            $table->string('location');
            $table->string('specialty');

            // ── Budget Matcher Pricing ─────────────────────────────────
            // min_budget: Starting price per guest (cheapest package/menu)
            // max_budget: Maximum price per guest (premium package/menu)
            // Replaces the old single price_per_guest column.
            // Used by the Budget Matcher to connect customers with caterers.
            $table->decimal('min_budget', 10, 2)->default(0);
            $table->decimal('max_budget', 10, 2)->default(0);

            // ── Profile & Documents ────────────────────────────────────
            $table->string('profile_picture')->nullable();
            $table->string('business_permit')->nullable();
            $table->string('sanitary_permit')->nullable();
            $table->string('government_id')->nullable();

            // ── Verification Status ────────────────────────────────────
            // Values: 'pending' | 'verified'
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caterer_profiles');
    }
};