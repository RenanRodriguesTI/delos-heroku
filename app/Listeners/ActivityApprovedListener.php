<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Events\ActivityApproved;
use Delos\Dgp\Entities\TypeNotify;
use Delos\Dgp\Repositories\Contracts\ApprovedNotificationRepository;

class ActivityApprovedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ActivityApproved $event)
    {
        $activity = $event->activity;
        $leader = \Auth::user(); 

        $type = TypeNotify::where('name','Atividade')->first();

        app(ApprovedNotificationRepository::class)->create([
            'title'=>'Atividade Aprovada',
            'subtitle' =>'A atividade foi aprovada pelo lider '.$leader->name." do Projeto: ".$activity->project->fulldescription,
            'approved'=>true,
            'ready'=>false,
            'value'=>$activity->hours,
            'user_id'=> $activity->user_id,
            'leader_id'=>$leader->id,
            'type_notify_id'=>$type->id
        ]);
    }
}
