<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolucitudSaegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_saegs', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->text('description')->nullable();
        $table->integer('state');
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
        Schema::dropIfExists('solucitud_saegs');
    }
}
