<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateCarsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('car_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('tolls', function(Blueprint $table) {
            $table->increments('id');
            $table->float('value');
            $table->timestamps();
        });

        Schema::create('cars', function(Blueprint $table) {
            $table->integer('request_id')->unsigned();
            $table->integer('car_type_id')->unsigned();
            $table->datetime('withdrawal_date')->nullable();
            $table->datetime('return_date')->nullable();
            $table->string('withdrawal_place')->nullable();
            $table->string('return_place')->nullable();
            $table->integer('first_driver_id')->unsigned()->nullable();
            $table->integer('second_driver_id')->unsigned()->nullable();

            $table->primary('request_id');
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('car_type_id')->references('id')->on('car_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('first_driver_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('second_driver_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('cars');
        Schema::drop('tolls');
        Schema::drop('car_types');
    }

}