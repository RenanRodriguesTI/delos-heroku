<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnAirportsTable extends Migration
{

    public function up()
    {
        Schema::table('airports', function (Blueprint $table) {
            $table->dropForeign('airports_ibfk_1');
            $table->foreign('state_id')
                ->references('id')
                ->on('states');
        });
    }


    public function down()
    {
        Schema::table('airports', function (Blueprint $table) {
            $table->dropForeign('airports_state_id_foreign');
            $table->foreign('state_id', 'airports_ibfk_1')
                ->references('id')
                ->on('states')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
