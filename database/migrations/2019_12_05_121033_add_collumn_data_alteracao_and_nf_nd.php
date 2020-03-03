<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollumnDataAlteracaoAndNfNd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_proposal_values',function(Blueprint $table){
            $table->date('date_change');
            $table->string('nf_nd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_proposal_values', function(Blueprint $table){
            $table->dropColumn('date_change');
            $table->dropColumn('nf_nd');
        });
    }
}
