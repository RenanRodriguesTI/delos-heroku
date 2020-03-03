<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\ProjectType;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddedTasksProjectType
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var array
     */
    public $tasks;
    /**
     * @var ProjectType
     */
    public $projectType;

    /**
     * Create a new event instance.
     *
     * @param array $tasks
     * @param ProjectType $projectType
     */
    public function __construct(array $tasks, ProjectType $projectType)
    {
        $this->tasks = $tasks;
        $this->projectType = $projectType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
