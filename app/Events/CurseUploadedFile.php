<?php

namespace Delos\Dgp\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Delos\Dgp\Entities\Curse;

class CurseUploadedFile
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $curse;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Curse $curse)
    {
        $this->curse = $curse;
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
