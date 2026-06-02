<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caterer_profile_id')->constrained()->onDelete('cascade');
            $table->string('name');                          // e.g. "Silver Package"
            $table->text('description')->nullable();
            $table->decimal('price_per_guest', 10, 2);      // price per head for this package
            $table->integer('min_guests')->default(50);      // minimum pax
            $table->integer('max_guests')->nullable();       // maximum pax (null = unlimited)
            $table->text('inclusions')->nullable();          // comma-separated or JSON list
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};