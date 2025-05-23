<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('album_reviews', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('comment');
        $table->tinyInteger('rating');
        $table->date('date');
        $table->foreignId('user_id')->constrained('users')->nullable()->onDelete('cascade');
        $table->foreignId('album_id')->constrained('albums')->nullable(false)->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
