<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('caterer_profiles', function (Blueprint $table) {
        $table->string('gcash_number')->nullable()->after('status');
        $table->string('gcash_qr_path')->nullable()->after('gcash_number');
    });
}

public function down()
{
    Schema::table('caterer_profiles', function (Blueprint $table) {
        $table->dropColumn(['gcash_number', 'gcash_qr_path']);
    });

    }
};
