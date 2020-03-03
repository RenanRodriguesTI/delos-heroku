<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLodgingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });

        Schema::create('lodgings', function(Blueprint $table) {
            $table->integer('request_id')->unsigned();
            $table->primary('request_id');
            $table->date('check_in');
            $table->date('checkout');
            $table->integer('city_id')->unsigned();
            $table->integer('second_city_id')->unsigned()->nullable();
            $table->string('suggestion')->nullable();
            $table->integer('hotel_room_id')->unsigned();

            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hotel_room_id')->references('id')->on('hotel_rooms')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('lodgings');
        Schema::drop('hotel_rooms');
    }
}
