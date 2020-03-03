<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_ibfk_1');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table->dropForeign('users_ibfk_2');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_company_id_foreign');
            $table->foreign('company_id', 'users_ibfk_1')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('users_role_id_foreign');
            $table->foreign('role_id', 'users_ibfk_2')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }
}
