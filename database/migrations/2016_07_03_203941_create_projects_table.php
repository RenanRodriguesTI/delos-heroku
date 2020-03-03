<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('financial_ratings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('cod')->unique();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('project_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');

            $table->string('cod')->nullable();
            $table->string('compiled_cod')->nullable();

            $table->integer('project_type_id')->unsigned();
            $table->foreign('project_type_id')
                ->references('id')
                ->on('project_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('financial_rating_id')->unsigned();
            $table->foreign('financial_rating_id')
                ->references('id')
                ->on('financial_ratings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('co_owner_id')->unsigned()->nullable();
            $table->foreign('co_owner_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('budget')->unsigned();
            $table->double('proposal_value');
            $table->string('proposal_number');

            $table->date('start');
            $table->date('finish');

            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('client_project', function (Blueprint $table) {
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['client_id', 'project_id']);
        });


        Schema::create('project_task', function (Blueprint $table) {
            $table->integer('project_id')->unsigned();
            $table->integer('task_id')->unsigned();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['project_id', 'task_id']);
        });

        Schema::create('project_user', function (Blueprint $table) {

            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['project_id', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_user');
        Schema::drop('project_task');
        Schema::drop('client_project');

        Schema::drop('projects');

        //Others table
        Schema::drop('financial_ratings');
        Schema::drop('project_types');
    }
}
