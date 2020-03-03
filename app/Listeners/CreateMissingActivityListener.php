<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Entities\MissingActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Entities\User;

class CreateMissingActivityListener implements ShouldQueue
{

    /**
     * @var MissingActivity
     */
    private $missingActivity;

    public function __construct(MissingActivity $missingActivity)
    {
        $this->missingActivity = $missingActivity;
    }

    public function handle($event)
    {
        $activity = $event->activity;
        $user = $activity->user;

        if($activity->date->isWeekday() && $this->isCollaborator($user)) {
            $missingActivity = $user->missingActivities()->firstOrNew(['date' => $activity->date]);
            $missingActivity->hours += $activity->hours;
            $missingActivity->save();
        }

        //propagating to other listeners
        return true;
    }

    private function isCollaborator(User $user)
    {
        return $user->role->slug == 'collaborator';
    }

    public function subscribe($events)
    {
        $events->listen(
            'Delos\Dgp\Events\DeleteActivityEvent',
            'Delos\Dgp\Listeners\CreateMissingActivityListener@handle'
        );

        $events->listen(
            'Delos\Dgp\Events\DeletedRestEvent',
            'Delos\Dgp\Listeners\CreateMissingActivityListener@handle'
        );
    }
}
