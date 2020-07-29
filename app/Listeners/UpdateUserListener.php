<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Delos\Dgp\Entities\UserOffice;
use Delos\Dgp\Entities\Office;
use Delos\Dgp\Entities\OfficeHistory;

class UpdateUserListener
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
        $now = Carbon::now();
        $user = $event->user;
        $data = $event->data;

        $last = UserOffice::where('user_id',$user->id)
        ->where('start', Carbon::createFromFormat('d/m/Y',$data['start'])->format('Y-m-d'))
        ->where('office_id',$data['office_id'])->first();

        //$office = Office::find($data['office_id']);
        if(!$last){
            // $history = OfficeHistory::where('office_id',$data['office_id'])->whereRaw("STR_TO_DATE('{$data['start']}','%d/%m/%Y') between start and finish")
            // ->orderBy('start','desc')->get()->first();
            // $history = $history ?? OfficeHistory::where('office_id',$data['office_id'])
            // ->where('start','<=',Carbon::createFromFormat('d/m/Y',$data['start']))
            // ->whereNull('finish')->get()->first();

            UserOffice::create([
                'user_id' => $user->id,
                'office_id' =>$data['office_id'],
                'start' => $data['start'],
            ]);
        }
        
        
        
    }
}
