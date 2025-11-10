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
        Schema::create('link_hubs', function (Blueprint $table) {
            $table->id();
            $table->string('scope', 20)->default('global'); // 'global' or 'hat'
            $table->uuid('hat_id')->nullable();
            $table->jsonb('links');                         // [{label,url,auth}]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_hubs');
    }
};
