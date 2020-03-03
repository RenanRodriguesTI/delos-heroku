<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnRequestsTable extends Migration
{

    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_ibfk_3');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');

            $table->dropForeign('requests_ibfk_4');
            $table->foreign('requester_id')
                ->references('id')
                ->on('users');

        });
    }

    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_project_id_foreign');
            $table->foreign('project_id', 'requests_ibfk_3')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('requests_requester_id_foreign');
            $table->foreign('requester_id', 'requests_ibfk_4')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
