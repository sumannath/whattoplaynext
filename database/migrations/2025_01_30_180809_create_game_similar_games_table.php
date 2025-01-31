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
        Schema::create('similar_games', function (Blueprint $table) {
            $table->foreignId('game_id')->constrained();
            $table->integer('similar_game_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['game_id','similar_game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('similar_games');
    }
};
