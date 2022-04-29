<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDriverApi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_api', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_file_drivers')->nullable();
          $table->text('tenantid')->nullable();
          $table->text('vehicleid')->nullable();
          $table->text('driverid')->nullable();
          $table->text('vehicleTypeList')->nullable();
          $table->date('dmigrado')->nullable();
          $table->boolean('documents')->nullable();
          $table->boolean('migrado')->nullable();
          $table->boolean('estatusapi')->nullable();
          $table->integer('modified_by')->nullable()->default('1');
          $table->timestamp('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();
          $table->boolean('status_system')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_api');
    }
}
