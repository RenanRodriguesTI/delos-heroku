<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Project;
use Illuminate\Queue\SerializesModels;

class CreatedProjectEvent extends Event
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
