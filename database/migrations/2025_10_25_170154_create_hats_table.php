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
        Schema::create('hats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug', 12)->unique();      // nanoid-like slug
            $table->unsignedInteger('serial')->nullable(); // optional numbering later
            $table->foreignId('user_id')->nullable()->constrained('users'); // owner
            $table->timestamp('first_scan_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hats');
    }
};
