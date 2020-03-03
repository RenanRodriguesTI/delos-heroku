<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProjectProposalValuesAddCollumnsOsAndDatanf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_proposal_values', function(Blueprint $table){
            $table->date('date_nf');
            $table->date('date_received');
            $table->string('os')->unique()->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_proposal_values',function(Blueprint $table){
            $table->dropColumn('date_nf');
            $table->dropColumn('date_received');
            $table->dropColumn('os');
        });
    }
}
