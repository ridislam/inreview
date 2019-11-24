<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('review')->nullable();
            $table->integer('rating');
            $table->morphs('reviewable');
            $table->unsignedBigInteger('user_id');
            $table->index('reviewable_id');
            $table->index('reviewable_type');
            $table->foreign('user_id')->references('id')->on(config('inreview.tables.user'));
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
}
