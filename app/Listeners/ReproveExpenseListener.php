<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\ReproveExpense;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Entities\TypeNotify;
use Delos\Dgp\Repositories\Contracts\ApprovedNotificationRepository;

class ReproveExpenseListener
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
    public function handle(ReproveExpense $event)
    {
        $expense = $event->expense;
        $leader = \Auth::user(); 

        $type = TypeNotify::where('name','Despesa')->first();

        app(ApprovedNotificationRepository::class)->create([
            'title'=>'Despesa Reprovada',
            'subtitle' =>'A despesa foi reprovada pelo lider '.$leader->name." do Projeto: ".$expense->project->fulldescription,
            'approved'=>false,
            'ready'=>false,
            'value'=>$expense->value,
            'user_id'=> $expense->user_id,
            'leader_id'=>$leader->id,
            'type_notify_id'=>$type->id
        ]);
    }
}
