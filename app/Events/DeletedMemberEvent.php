<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Project;
use Illuminate\Queue\SerializesModels;

class DeletedMemberEvent extends Event
{
    use SerializesModels;

    public $memberId;
    public $project;

    public function __construct(int $memberId, Project $project)
    {
        $this->memberId = $memberId;
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
