<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\ProjectType;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RemovedTasksProjectType
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var array
     */
    public $taskId;
    /**
     * @var ProjectType
     */
    public $projectTypeId;

    /**
     * Create a new event instance.
     *
     * @param int $taskId
     * @param int $projectTypeId
     */
    public function __construct(int $taskId, int $projectTypeId)
    {
        $this->taskId = $taskId;
        $this->projectTypeId = $projectTypeId;
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
