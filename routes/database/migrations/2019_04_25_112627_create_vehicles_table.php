<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
          $table->increments('id');
          $table->text('number_enrollment');
          $table->text('brand');
          $table->text('model');
          $table->text('color');
          $table->text('nro_doors');
          $table->text('model_year');

          $table->integer('id_driver')->unsigned();
          $table->foreign('id_driver')->references('id')->on('drivers');

          $table->integer('id_customer_owner')->unsigned();
          $table->foreign('id_customer_owner')->references('id')->on('customers');

          $table->integer('id_typebodyworks')->unsigned();
          $table->foreign('id_typebodyworks')->references('id')->on('type_bodyworks');


          $table->text('note')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
