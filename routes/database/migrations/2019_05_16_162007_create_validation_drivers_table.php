<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidationDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_driver_val');
            $table->integer('status_driver_fi');
            $table->integer('id_customer');
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->integer('id_vehicle');
            $table->foreign('id_vehicle')->references('id')->on('vehicles');
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
        Schema::dropIfExists('validation_drivers');
    }
}
