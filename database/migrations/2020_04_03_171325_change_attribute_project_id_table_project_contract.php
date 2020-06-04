<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAttributeProjectIdTableProjectContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_project',function(Blueprint $table){
            $table->integer('project_id')->nullable(true)->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_project',function(Blueprint $table){

            $table->integer('project_id')->nullable(false)->unsigned()->change();
        });
    }
}
