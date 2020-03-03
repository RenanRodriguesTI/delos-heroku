<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUniquesColumnsCommonForMultiTenanty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropUnique('groups_cod_unique');
            $table->dropUnique('groups_name_unique');

            $table->unique(['cod', 'group_company_id']);
            $table->unique(['name', 'group_company_id']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropUnique('clients_name_unique');

            $table->unique(['name', 'group_company_id']);
        });

        Schema::table('project_types', function (Blueprint $table) {
            $table->dropUnique('project_types_name_unique');

            $table->unique(['name', 'group_company_id']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropUnique('tasks_name_unique');

            $table->unique(['name', 'group_company_id']);
        });

        Schema::table('financial_ratings', function (Blueprint $table) {
            $table->dropUnique('financial_ratings_cod_unique');

            $table->unique(['cod', 'group_company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropUnique('groups_cod_group_company_id_unique');
            $table->dropUnique('groups_name_group_company_id_unique');

            $table->unique(['cod']);
            $table->unique(['name']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropUnique('clients_name_group_company_id_unique');

            $table->unique(['name']);
        });

        Schema::table('project_types', function (Blueprint $table) {
            $table->dropUnique('project_types_name_group_company_id_unique');

            $table->unique(['name']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropUnique('tasks_name_group_company_id_unique');

            $table->unique(['name']);
        });

        Schema::table('financial_ratings', function (Blueprint $table) {
            $table->dropUnique('financial_ratings_cod_group_company_id_unique');

            $table->unique(['cod']);
        });
    }
}
