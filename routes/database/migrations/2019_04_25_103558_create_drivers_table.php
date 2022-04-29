<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('number_license')->nullable();
            $table->text('category')->nullable();
            $table->integer('id_country_driving');
            $table->date('date_expiration');
            $table->integer('points')->nullable();
            $table->integer('points_limit')->nullable();
            $table->integer('id_customer');
            $table->foreign('id_country_driving')->references('id')->on('country');
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->text('note')->nullable();
            $table->integer('modified_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('status_system')->nullable()->default(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
