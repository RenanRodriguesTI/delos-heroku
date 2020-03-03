<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnLodgingsTable extends Migration
{

    public function up()
    {
        Schema::table('lodgings', function (Blueprint $table) {

            $table->dropForeign('lodgings_ibfk_1');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');

            $table->dropForeign('lodgings_ibfk_2');
            $table->foreign('hotel_room_id')
                ->references('id')
                ->on('hotel_rooms');

            $table->dropForeign('lodgings_ibfk_3');
            $table->foreign('request_id')
                ->references('id')
                ->on('requests');

            $table->dropForeign('lodgings_ibfk_4');
            $table->foreign('second_city_id')
                ->references('id')
                ->on('cities');
        });
    }

    public function down()
    {
        Schema::table('lodgings', function (Blueprint $table) {
            $table->dropForeign('lodgings_city_id_foreign');
            $table->foreign('city_id', 'lodgings_ibfk_1')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('lodgings_hotel_room_id_foreign');
            $table->foreign('hotel_room_id', 'lodgings_ibfk_2')
                ->references('id')
                ->on('hotel_rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('lodgings_request_id_foreign');
            $table->foreign('request_id', 'lodgings_ibfk_3')
                ->references('id')
                ->on('requests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('lodgings_second_city_id_foreign');
            $table->foreign('second_city_id', 'lodgings_ibfk_4')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
