<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\Project;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class EditedProjectEvent
{
    use InteractsWithSockets, SerializesModels;


    /**
     * @var \Delos\Dgp\Entities\User
     */
    public $authenticatedUser;
    public $originalProject;
    public $editedProject;

    public function __construct(Project $originalProject, Project $editedProject)
    {
        $this->authenticatedUser = app('auth')->getUser();
        $this->originalProject = $originalProject;
        $this->editedProject = $editedProject;
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
