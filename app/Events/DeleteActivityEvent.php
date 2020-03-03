<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Activity;

class DeleteActivityEvent extends Event
{

    public $activity;

    /**
     * @var \Delos\Dgp\Entities\User
     */
    public $authenticatedUser;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
        $this->authenticatedUser = \Auth::user();
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
