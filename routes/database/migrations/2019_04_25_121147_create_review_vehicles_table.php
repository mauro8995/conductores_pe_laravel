<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_review');
            $table->integer('quantity_infringement')->nullable();
            $table->integer('amount_infringement')->nullable();
            $table->text('url_origen')->nullable();
            $table->text('soat')->nullable();
            $table->date('date_soat_expiration')->nullable();

            $table->integer('id_driver')->nullable();
            $table->foreign('id_driver')->references('id')->on('drivers');

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
        Schema::dropIfExists('review_vehicles');
    }
}
