<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVehicleDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_documents', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_file_drivers')->nullable();
          $table->text('fileurl')->nullable();
          $table->text('tpdocument')->nullable();
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
        Schema::dropIfExists('vehicle_documents');
    }
}
