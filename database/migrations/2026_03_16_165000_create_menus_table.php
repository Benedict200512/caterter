<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caterer_profile_id')->constrained()->onDelete('cascade');
            $table->string('name');                          // e.g. "Lechon Paksiw"
            $table->string('category')->nullable();          // e.g. "Main Course", "Dessert", "Drinks"
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);     // price per serving/item
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};