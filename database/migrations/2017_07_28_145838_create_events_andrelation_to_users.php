<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsAndrelationToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('event_user', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        $events = [
            [
                'name' => 'complete-project',
                'description' => 'People who need to receive an email when a project is completed',
            ],
            [
                'name' => 'approve-activities',
                'description' => 'People who need to receive an email when there are activities to be approved',
            ],
            [
                'name' => 'approve-request',
                'description' => 'Person responsible for approving requests',
            ],
            [
                'name' => 'created-project',
                'description' => 'People who need to receive an email when a project is created',
            ],
            [
                'name' => 'edited-project',
                'description' => 'People who need to receive an email when a project is edited',
            ],
            [
                'name' => 'created-request',
                'description' => 'People who need to receive an email when a request is created',
            ],
            [
                'name' => 'created-project-add-hours-per-task',
                'description' => 'People who need to receive an email when a project is created to be fill the hours per task',
            ],
            [
                'name' => 'request-summary',
                'description' => 'People who need to receive an email with summary when a request is created',
            ],
            [
                'name' => 'absences',
                'description' => 'People who need to receive an email with the activities where task is absences',
            ],
            [
                'name' => 'signed-plan',
                'description' => 'Person responsible for generate bank slip',
            ],
        ];

        foreach ($events as $index => $event) {
            DB::transaction(function () use ($event){
                \DB::table('events')
                    ->insert($event);
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
        Schema::table('event_user', function (Blueprint $table) {
            $table->dropForeign('event_user_event_id_foreign');
            $table->dropForeign('event_user_user_id_foreign');
        });

        Schema::dropIfExists('events');
        Schema::dropIfExists('event_user');
    }
}
