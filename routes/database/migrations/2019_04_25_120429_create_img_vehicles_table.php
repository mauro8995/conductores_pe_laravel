<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->text('url_image')->nullable();
            $table->integer('id_vehicle')->unsigned();
            $table->foreign('id_vehicle')->references('id')->on('vehicles');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('modified_by')->nullable()->default('1');
            $table->boolean('status_system')->nullable()->default(true);
            $table->boolean('status_user'  )->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('img_vehicles');
    }
}
