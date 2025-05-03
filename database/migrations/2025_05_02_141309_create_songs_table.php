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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->timestamp('release_date');
            $table->string('audio');

            $table->foreignId('album_id')->constrained('albums')->nullable();
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('restrict');
            $table->foreignId('language_id')->constrained('languages')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
