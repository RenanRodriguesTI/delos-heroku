<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_ibfk_1');
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_group_id_foreign');
            $table->foreign('group_id', 'clients_ibfk_1')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');
        });
    }
}
