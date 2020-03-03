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

class SavedAllocation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Allocation
     */
    public $allocation;

    /**
     * Create a new event instance.
     *
     * @param Allocation $allocation
     */
    public function __construct(Allocation $allocation)
    {
        $this->allocation = $allocation;
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
