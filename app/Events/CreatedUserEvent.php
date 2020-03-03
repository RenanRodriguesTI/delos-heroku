<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\User;
use Illuminate\Queue\SerializesModels;

class CreatedUserEvent extends Event
{
    use SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
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
