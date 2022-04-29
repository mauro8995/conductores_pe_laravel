<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProcesoValCond extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_val_cond', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_file_drivers');
          $table->foreign('id_file_drivers')->references('id')->on('file_drivers');

          $table->integer('id_proceso_validacion');
          $table->foreign('id_proceso_validacion')->references('id')->on('proceso_validacion');

          $table->boolean('estatus_proceso')->nullable();
          $table->boolean('approved')->nullable();
          $table->text('description');
          $table->integer('created_by');
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
        Schema::dropIfExists('proceso_val_cond');
    }
}
