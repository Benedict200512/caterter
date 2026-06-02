<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds: address, date_of_birth, phone, username to existing users table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable()->after('name');
            $table->date('date_of_birth')->nullable()->after('address');
            $table->string('phone', 20)->nullable()->unique()->after('date_of_birth');
            $table->string('username', 30)->nullable()->unique()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'date_of_birth', 'phone', 'username']);
        });
    }
};