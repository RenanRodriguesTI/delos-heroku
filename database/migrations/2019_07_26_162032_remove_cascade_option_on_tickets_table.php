<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnTicketsTable extends Migration
{

    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_ibfk_1');
            $table->dropForeign('tickets_ibfk_2');
            $table->dropForeign('tickets_ibfk_3');
            $table->foreign('from_airport_id')
                ->references('id')
                ->on('airports');

            $table->foreign('request_id')
                ->references('id')
                ->on('requests');

            $table->foreign('to_airport_id')
                ->references('id')
                ->on('airports');

        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_from_airport_id_foreign');
            $table->dropForeign('tickets_request_id_foreign');
            $table->dropForeign('tickets_to_airport_id_foreign');

            $table->foreign('from_airport_id', 'tickets_ibfk_1')
                ->references('id')
                ->on('airports')
                ->onDelete('cascade');

            $table->foreign('request_id', 'tickets_ibfk_2')
                ->references('id')
                ->on('requests')
                ->onDelete('cascade');

            $table->foreign('to_airport_id', 'tickets_ibfk_3')
                ->references('id')
                ->on('airports')
                ->onDelete('cascade');
        });
    }
}
