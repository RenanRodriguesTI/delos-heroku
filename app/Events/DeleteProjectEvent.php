<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Project;
use Delos\Dgp\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeleteProjectEvent extends Event
{
    use SerializesModels;

    public $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
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
