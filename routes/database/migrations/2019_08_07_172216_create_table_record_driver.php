<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRecordDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_driver', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_file_drivers');
          $table->foreign('id_file_drivers')->references('id')->on('file_drivers');

          $table->integer('id_user_offices');
          $table->foreign('id_user_offices')->references('id')->on('user_offices');

          $table->text('cod_falta')->nullable();
          $table->text('papeleta')->nullable();
          $table->text('entidad')->nullable();

          $table->integer('points_saldo')->nullable();
          $table->integer('points_firmes')->nullable();
          $table->date('dinfranccion')->nullable();
          $table->text('estado')->nullable();

          $table->text('note')->nullable();
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
        Schema::dropIfExists('record_driver');
    }
}
