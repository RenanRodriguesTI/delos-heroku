<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Entities\OfficeHistory;

class UpdatedOfficeListener
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
    public function handle($event)
    {
        $office = $event->office;

        $last = OfficeHistory::where('office_id',$office->id)->orderBy('created_at','desc')->first();

        $hasupdateHistory = false;

        if($last->start->format('d/m/Y') != $office->start->format('d/m/Y')){
            $hasupdateHistory = true;
        }else{
            if($last->finish != $office->finish){
                $hasupdateHistory = true;
            }
            else if($last->value != $office->value){
                $hasupdateHistory = true;
            }
        }

       if($hasupdateHistory){
        OfficeHistory::create([
            'office_id' =>$office->id,
            'start' =>$office->start->format('d/m/Y'),
            'finish' =>$office->finish ? $office->finish->format('d/m/Y'): null,
            'value' =>$office->value
        ]);
       }

    }
}
