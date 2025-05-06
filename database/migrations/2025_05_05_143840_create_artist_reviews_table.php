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
    Schema::create('artist_reviews', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('comment');
        $table->tinyInteger('rating');
        $table->date('date');
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        $table->foreignId('artist_id')->constrained('artists')->nullable(false)->onDelete('cascade');
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
