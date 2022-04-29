<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolucitudSaegDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_saeg_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_solicitud_saeg');
            $table->foreign('id_solicitud_saeg')->references('id')->on('solicitud_saegs');
            $table->integer('id_office');
            $table->foreign('id_office')->references('id')->on('user_offices');
            $table->integer('state')->default('1');
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
        Schema::dropIfExists('solucitud_saeg_details');
    }
}
