<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessTrace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_trace', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_file_drivers')->nullable();
            $table->integer('id_process_model')->nullable();
            $table->integer('sec_actual')->nullable();
            $table->integer('sec_sig')->nullable();
            $table->boolean('estatus')->nullable();
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
        Schema::dropIfExists('process_trace');
    }
}
