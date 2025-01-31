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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug',210);
            $table->foreignId('category_id')->constrained();
            $table->text('summary');
            $table->date('first_release_date')->nullable();
            $table->date('igdb_created');
            $table->date('igdb_updated');
            $table->text('igdb_url');
            $table->text('storyline');

            $table->fullText('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
