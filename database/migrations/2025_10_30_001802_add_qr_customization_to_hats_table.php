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
        Schema::table('hats', function (Blueprint $table) {
            $table->string('qr_fg_color', 20)->default('#000000')->after('city');
            $table->string('qr_bg_color', 20)->default('#FFFFFF')->after('qr_fg_color');
            $table->string('qr_logo_path', 255)->nullable()->after('qr_bg_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hats', function (Blueprint $table) {
            $table->dropColumn(['qr_fg_color', 'qr_bg_color', 'qr_logo_path']);
        });
    }
};
