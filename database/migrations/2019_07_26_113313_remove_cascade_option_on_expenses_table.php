<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnExpensesTable extends Migration
{

    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_ibfk_1');
            $table->foreign('payment_type_id')
                ->references('id')
                ->on('payment_types');

            $table->dropForeign('expenses_ibfk_2');
            $table->foreign('request_id')
                ->references('id')
                ->on('requests');

            $table->dropForeign('expenses_ibfk_3');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->dropForeign('expenses_project_id_foreign');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');

        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_payment_type_id_foreign');
            $table->foreign('payment_type_id', 'expenses_ibfk_1')
                ->references('id')
                ->on('payment_types')
                ->onDelete('cascade');

            $table->dropForeign('expenses_request_id_foreign');
            $table->foreign('request_id', 'expenses_ibfk_2')
                ->references('id')
                ->on('requests')
                ->onDelete('cascade');

            $table->dropForeign('expenses_user_id_foreign');
            $table->foreign('user_id', 'expenses_ibfk_3')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->dropForeign('expenses_project_id_foreign');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');
        });
    }
}
