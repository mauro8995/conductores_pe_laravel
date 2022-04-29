<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_offices');
            $table->foreign('id_user_offices')->references('id')->on('user_offices');
            $table->text('car_interna')->nullable();
            $table->text('car_interna2')->nullable();
            $table->text('car_externa')->nullable();
            $table->text('car_externa2')->nullable();
            $table->text('car_externa3')->nullable();
            $table->text('obs_vehi')->nullable();
            $table->text('dni_frontal')->nullable();
            $table->text('dni_back')->nullable();
            $table->text('dni')->nullable();
            $table->date('dnifecemi')->nullable();
            $table->date('dnifecven')->nullable();
            $table->text('licencia')->nullable();
            $table->date('licfecemi')->nullable();
            $table->date('licfecven')->nullable();
            $table->text('placa')->nullable();
            $table->text('marca')->nullable();
            $table->text('model')->nullable();
            $table->integer('year')->nullable();
            $table->text('revision_tecnica')->nullable();
            $table->date('revfecemi')->nullable();
            $table->date('revfecven')->nullable();
            $table->text('lic_frontal')->nullable();
            $table->text('lic_back')->nullable();
            $table->text('soat_frontal')->nullable();
            $table->text('soat_back')->nullable();
            $table->date('soatfecemi')->nullable();
            $table->date('soatfecven')->nullable();
            $table->text('tar_veh_frontal')->nullable();
            $table->text('tar_veh_back')->nullable();
            $table->date('tar_vehfecemi')->nullable();
            $table->date('tar_vehfecven')->nullable();
            $table->text('recibo_luz')->nullable();
            $table->text('photo_perfil')->nullable();
            $table->text('color_car')->nullable();
            $table->text('num_vin')->nullable();
            $table->text('num_motor')->nullable();
            $table->text('est_car')->nullable();
            $table->text('classcategoria')->nullable();
            $table->text('est_licencia')->nullable();
            $table->text('enterprisesoat')->nullable();
            $table->text('url_antecedentes')->nullable();
            $table->text('est_soat')->nullable();
            $table->text('type_soat')->nullable();
            $table->text('type_safe')->nullable();
            $table->text('nro_poliza')->nullable();
            $table->integer('status_user')->nullable();
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
        Schema::dropIfExists('file_drivers');
    }
}
