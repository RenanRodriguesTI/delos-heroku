<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAttributesTypeDateProjectProposalValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_proposal_values',function(Blueprint $table){
            $table->date('date_nf')->nullable(true)->change();
            $table->date('date_received')->nullable(true)->change();
            $table->date('date_change')->nullable(true)->change();
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
            $table->date('date_nf')->nullable(false)->change();
            $table->date('date_received')->nullable(false)->change();
            $table->date('date_change')->nullable(false)->change();
        });
    }
}
