<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Allocation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateTaskAllocation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $allocation;
    public $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Allocation $allocation, $task)
    {
        $this->allocation = $allocation;
        $this->task = $task;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
