<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnCarsTable extends Migration
{

    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {

            $table->dropForeign('cars_ibfk_1');
            $table->foreign('car_type_id')
                ->references('id')
                ->on('car_types');

            $table->dropForeign('cars_ibfk_2');
            $table->foreign('first_driver_id')
                ->references('id')
                ->on('users');

            $table->dropForeign('cars_ibfk_3');
            $table->foreign('request_id')
                ->references('id')
                ->on('requests');
            $table->dropForeign('cars_ibfk_4');
            $table->foreign('second_driver_id')
                ->references('id')
                ->on('users');
        });
    }

    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign('cars_car_type_id_foreign');
            $table->foreign('car_type_id', 'cars_ibfk_1')
                ->references('id')
                ->on('car_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('cars_first_driver_id_foreign');
            $table->foreign('first_driver_id', 'cars_ibfk_2')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('cars_request_id_foreign');
            $table->foreign('request_id', 'cars_ibfk_3')
                ->references('id')
                ->on('requests')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dropForeign('cars_second_driver_id_foreign');
            $table->foreign('second_driver_id', 'cars_ibfk_4')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
