<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupCompanyIdInYourChildren extends Migration
{
    private const TABLES = [
        'users',
        'companies',
        'groups',
        'clients',
        'financial_ratings',
        'project_types',
        'tasks'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedInteger('group_company_id')->nullable();
                $table->foreign('group_company_id')->references('id')->on('group_companies');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (self::TABLES as $tableDatabase) {
            Schema::table($tableDatabase, function (Blueprint $table) use ($tableDatabase) {
                $table->dropForeign($tableDatabase . '_group_company_id_foreign');
                $table->dropColumn('group_company_id');
            });
        }
    }
}
