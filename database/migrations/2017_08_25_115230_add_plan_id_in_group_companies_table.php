<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanIdInGroupCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('group_companies', function (Blueprint $table) {
            $table->unsignedInteger('plan_id');
            $table->foreign('plan_id')
                ->references('id')
                ->on('plans');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_companies', function (Blueprint $table) {
            $table->dropForeign('group_companies_plan_id_foreign');
            $table->dropColumn('plan_id');
        });
    }
}
