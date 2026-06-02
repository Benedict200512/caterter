<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FIX #12: Add caterer right-of-reply to reviews.
     * Per Policy 1.10 - Caterers are entitled to a "Right of Reply" for any public review.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->text('caterer_reply')->nullable()->after('comment');
            $table->timestamp('caterer_reply_at')->nullable()->after('caterer_reply');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['caterer_reply', 'caterer_reply_at']);
        });
    }
};