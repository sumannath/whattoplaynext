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
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('slug',200);
            $table->string('alternative_name',200);
            $table->integer('generation')->nullable();
            $table->integer('platform_family')->nullable();
            $table->string('abbreviation',200);
            $table->text('summary');
            $table->date('igdb_created');
            $table->date('igdb_updated');
            $table->text('igdb_url');
            $table->text('igdb_checksum');
            $table->integer('igdb_logo_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};
