<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnActivitiesTable extends Migration
{

    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign('activities_ibfk_2');
            $table->foreign('place_id')
                ->references('id')
                ->on('places');

            $table->dropForeign('activities_ibfk_3');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');

            $table->dropForeign('activities_ibfk_4');
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks');

            $table->dropForeign('activities_ibfk_5');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign('activities_place_id_foreign');
            $table->foreign('place_id', 'activities_ibfk_2')
                ->references('id')
                ->on('places')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('activities_project_id_foreign');
            $table->foreign('project_id', 'activities_ibfk_3')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('activities_task_id_foreign');
            $table->foreign('task_id', 'activities_ibfk_4')
                ->references('id')
                ->on('tasks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->dropForeign('activities_user_id_foreign');
            $table->foreign('user_id', 'activities_ibfk_5')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
