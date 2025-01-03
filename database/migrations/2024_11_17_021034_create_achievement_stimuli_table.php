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
        Schema::create('achievement_stimuli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained('achievements');
            $table->foreignId('stimuli_id')->constrained('stimuli');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_stimuli');
    }
};
