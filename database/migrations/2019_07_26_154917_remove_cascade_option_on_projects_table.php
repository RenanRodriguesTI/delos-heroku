<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_ibfk_1');
            $table->dropForeign('projects_ibfk_2');
            $table->dropForeign('projects_ibfk_3');
            $table->dropForeign('projects_ibfk_4');
            $table->dropForeign('projects_ibfk_5');

            $table->foreign('co_owner_id')
                ->references('id')
                ->on('users');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table->foreign('financial_rating_id')
                ->references('id')
                ->on('financial_ratings');

            $table->foreign('owner_id')
                ->references('id')
                ->on('users');

            $table->foreign('project_type_id')
                ->references('id')
                ->on('project_types');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_co_owner_id_foreign');
            $table->dropForeign('projects_company_id_foreign');
            $table->dropForeign('projects_financial_rating_id_foreign');
            $table->dropForeign('projects_owner_id_foreign');
            $table->dropForeign('projects_project_type_id_foreign');

            $table->foreign('co_owner_id', 'projects_ibfk_1')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('company_id', 'projects_ibfk_2')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->foreign('financial_rating_id', 'projects_ibfk_3')
                ->references('id')
                ->on('financial_ratings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('owner_id', 'projects_ibfk_4')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('project_type_id', 'projects_ibfk_5')
                ->references('id')
                ->on('project_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
