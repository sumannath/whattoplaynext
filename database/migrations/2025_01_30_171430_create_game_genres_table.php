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
        Schema::create('game_genres', function (Blueprint $table) {
            $table->foreignId('game_id')->constrained();
            $table->foreignId('genre_id')->constrained();
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['game_id','genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_genres');
    }
};
