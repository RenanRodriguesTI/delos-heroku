<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnForNewValidationWhenClientPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('lodgings', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->nullable()->change();
            $table->integer('hotel_room_id')->unsigned()->nullable()->change();
            $table->unsignedInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('lodgings', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->change();
            $table->integer('hotel_room_id')->unsigned()->change();
            $table->dropForeign('lodgings_state_id_foreign');
            $table->dropColumn('state_id');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
