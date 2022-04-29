<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicalReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_file_drivers');
            $table->foreign('id_file_drivers')->references('id')->on('file_drivers');
            $table->integer('luz_baja')->nullable();
            $table->integer('luz_alta')->nullable();
            $table->integer('luz_freno')->nullable();
            $table->integer('luz_emergencia')->nullable();
            $table->integer('luz_retroceso')->nullable();
            $table->integer('luz_intermitente')->nullable();
            $table->integer('luz_antiniebla')->nullable();
            $table->integer('luz_placa')->nullable();
            $table->integer('arrancador')->nullable();
            $table->integer('alternador')->nullable();
            $table->integer('bujias')->nullable();
            $table->integer('cable_bujias')->nullable();
            $table->integer('bobinas')->nullable();
            $table->integer('inyectores')->nullable();
            $table->integer('bateria')->nullable();
            $table->integer('past_del')->nullable();
            $table->integer('past_tras')->nullable();
            $table->integer('disc_del')->nullable();
            $table->integer('disc_tras')->nullable();
            $table->integer('tamb_tras')->nullable();
            $table->integer('zapatas_tras')->nullable();
            $table->integer('freno_emerg')->nullable();
            $table->integer('liq_freno')->nullable();
            $table->integer('est_neumaticos')->nullable();
            $table->integer('rev_tuercas')->nullable();
            $table->integer('pres_neumat')->nullable();
            $table->integer('llanta_resp')->nullable();
            $table->integer('aros')->nullable();
            $table->integer('paracho_del')->nullable();
            $table->integer('paracho_post')->nullable();
            $table->integer('puert_del_izq')->nullable();
            $table->integer('puert_del_der')->nullable();
            $table->integer('puert_post_izq')->nullable();
            $table->integer('puert_post_der')->nullable();
            $table->integer('guardafango_izq')->nullable();
            $table->integer('guardafango_der')->nullable();
            $table->integer('capota')->nullable();
            $table->integer('vid_del_izq')->nullable();
            $table->integer('vid_del_der')->nullable();
            $table->integer('vid_post_izq')->nullable();
            $table->integer('vid_post_der')->nullable();
            $table->integer('parab_del')->nullable();
            $table->integer('parab_tras')->nullable();
            $table->integer('maletero')->nullable();
            $table->integer('techo')->nullable();
            $table->integer('fuga_aceite')->nullable();
            $table->integer('fuga_refrig')->nullable();
            $table->integer('fuga_combust')->nullable();
            $table->integer('filt_aceite')->nullable();
            $table->integer('filt_aire')->nullable();
            $table->integer('filt_combus')->nullable();
            $table->integer('filt_cabina')->nullable();
            $table->integer('bomba_direc')->nullable();
            $table->integer('amorti_del')->nullable();
            $table->integer('amorti_post')->nullable();
            $table->integer('palieres')->nullable();
            $table->integer('rotulas')->nullable();
            $table->integer('termin_direc')->nullable();
            $table->integer('trapezios')->nullable();
            $table->integer('resortes')->nullable();
            $table->integer('aceite_caja')->nullable();
            $table->integer('filtro_caja')->nullable();
            $table->integer('caja_transf')->nullable();
            $table->integer('cardan')->nullable();
            $table->integer('diferencial')->nullable();
            $table->integer('disco_embrague')->nullable();
            $table->integer('collarin')->nullable();
            $table->integer('cruzetas')->nullable();
            $table->integer('radiador')->nullable();
            $table->integer('ventiladores')->nullable();
            $table->integer('correa_vent')->nullable();
            $table->integer('mangueras_agua')->nullable();
            $table->integer('tablero')->nullable();
            $table->integer('luz_tablero')->nullable();
            $table->integer('luz_saloom')->nullable();
            $table->integer('asiento_piloto')->nullable();
            $table->integer('asiento_copiloto')->nullable();
            $table->integer('asientos_tras')->nullable();
            $table->integer('claxon')->nullable();
            $table->integer('gata')->nullable();
            $table->integer('llave_ruedas')->nullable();
            $table->integer('estuche_herra')->nullable();
            $table->integer('triangulo_seg')->nullable();
            $table->integer('extintor')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('technical_reviews');
    }
}
