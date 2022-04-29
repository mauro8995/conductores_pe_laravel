<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->text('url_image')->nullable();
            $table->integer('id_review_vehicles')->unsigned();
            $table->foreign('id_review_vehicles')->references('id')->on('review_vehicles');
            $table->text('note')->nullable();
            $table->integer('modified_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('status_system')->nullable()->default(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('img_reviews');
    }
}
