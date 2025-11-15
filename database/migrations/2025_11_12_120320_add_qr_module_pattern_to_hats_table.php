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
            $table->string('qr_module_pattern', 20)->default('margin')->after('qr_logo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hats', function (Blueprint $table) {
            $table->dropColumn('qr_module_pattern');
        });
    }
};
