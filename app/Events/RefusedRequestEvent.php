<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class RefusedRequestEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Request
     */
    public $request;
    public $reason;
    /**
     * @var \Delos\Dgp\Entities\User
     */
    public $authenticatedUser;

    public function __construct(Request $request, string $reason)
    {

        $this->request = $request;
        $this->reason = $reason;
        $this->authenticatedUser = app('auth')->getUser();
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
