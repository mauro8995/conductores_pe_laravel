<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProcesoValidacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_validacion', function (Blueprint $table) {
          $table->increments('id');
          $table->text('nombre')->nullable();
          $table->boolean('estatus')->nullable()->default(true);
          $table->boolean('obligatorio')->nullable()->default(true);
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
        Schema::dropIfExists('proceso_validacion');
    }
}
