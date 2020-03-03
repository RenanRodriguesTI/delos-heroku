<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Request;
use Illuminate\Queue\SerializesModels;

class CreatedRequestEvent extends Event
{
    use SerializesModels;
    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
