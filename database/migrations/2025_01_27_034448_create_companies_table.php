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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('slug',200);
            $table->smallInteger('country_id')->nullable();
            $table->text('description')->nullable();
            $table->date('igdb_created');
            $table->date('igdb_updated');
            $table->text('igdb_url');
            $table->text('igdb_checksum');
            $table->integer('igdb_logo_id')->nullable();
            $table->integer('igdb_parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
