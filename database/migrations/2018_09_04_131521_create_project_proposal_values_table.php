<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectProposalValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_proposal_values', function (Blueprint $table) {
            $table->increments('id');
            $table->date('month');
            $table->text('description');
            $table->decimal('value', 10, 2);
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('project_proposal_values');
        Schema::enableForeignKeyConstraints();
    }
}
