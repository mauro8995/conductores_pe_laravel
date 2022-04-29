<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRangoRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rango_record', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rangoa')->nullable();
            $table->integer('rangob')->nullable();
            $table->text('estatus')->nullable();
            $table->text('color')->nullable();
            $table->boolean('baprobado')->nullable();
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
        Schema::dropIfExists('rango_record');
    }
}
