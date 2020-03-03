<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnProjectProposalValuesTable extends Migration
{

    public function up()
    {
        Schema::table('project_proposal_values', function (Blueprint $table) {
            $table->dropForeign('project_proposal_values_project_id_foreign');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');
        });
    }

    public function down()
    {
        Schema::table('project_proposal_values', function (Blueprint $table) {
            $table->dropForeign('project_proposal_values_project_id_foreign');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
