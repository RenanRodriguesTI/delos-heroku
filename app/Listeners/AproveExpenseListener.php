<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Events\AproveExpense;
use Delos\Dgp\Entities\TypeNotify;
use Delos\Dgp\Repositories\Contracts\ApprovedNotificationRepository;

class AproveExpenseListener
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
    public function handle(AproveExpense $event)
    {
        $expense = $event->expense;
        $leader = \Auth::user(); 

        $type = TypeNotify::where('name','Despesa')->first();

        app(ApprovedNotificationRepository::class)->create([
            'title'=>'Despesa Aprovada',
            'subtitle' =>'A despesa foi aprovada pelo lider '.$leader->name." do Projeto: ".$expense->project->fulldescription,
            'approved'=>true,
            'ready'=>false,
            'value'=>$expense->value,
            'user_id'=> $expense->user_id,
            'leader_id'=>$leader->id,
            'type_notify_id'=>$type->id
        ]);
    }
}
