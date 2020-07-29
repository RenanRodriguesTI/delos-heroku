<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Entities\OfficeHistory;
use Delos\Dgp\Events\SavedOffice;

class SavedOfficeListener
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
    public function handle(SavedOffice $event)
    {
        $office = $event->office;

        OfficeHistory::create([
            'office_id' => $office->id,
            'start' => $office->start->format('d/m/Y'),
            'finish' =>$office->finish ? $office->finish->format('d/m/Y') :null,
            'value' => $office->value
        ]);
    }
}
