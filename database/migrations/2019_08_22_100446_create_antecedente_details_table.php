<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedenteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedente_details', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_antecedente');
          $table->foreign('id_antecedente')->references('id')->on('antecedentes');
          $table->integer('id_type_antecedente');
          $table->foreign('id_type_antecedente')->references('id')->on('type_antecedentes');
          $table->integer('id_type_reference');
          $table->foreign('id_type_reference')->references('id')->on('type_references');
          $table->text('crime')->nullable();
          $table->text('dependence')->nullable();
          $table->text('number_office')->nullable();
          $table->timestamp('date_register')->nullable();
          $table->text('situation')->nullable();
          $table->text('part')->nullable();
          $table->text('observation')->nullable();
          $table->integer('modify_by')->default('1');
          $table->integer('create_by')->default('1');
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
        Schema::dropIfExists('antecedente_details');
    }
}
