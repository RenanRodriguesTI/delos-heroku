<?php

    namespace Delos\Dgp\Listeners;

    use Illuminate\Contracts\Queue\ShouldQueue;
    use Delos\Dgp\Entities\User;

    /**
     * Class DeleteMissingActivityListener
     * @package Delos\Dgp\Listeners
     */
    class DeleteMissingActivityListener implements ShouldQueue
    {
        /**
         * @param $event
         */
        public function handle($event)
        {
            $activity = $event->activity;
            $user     = $event->activity->user;

            $missingActivity = $user->missingActivities()->firstOrNew(['date' => $activity->date]);

            if ( $activity->date->isWeekday() && $this->isCollaborator($user) ) {
                $missingHours = $missingActivity->hours > 0 ? $missingActivity->hours : 8;

                $missingActivity->hours = $missingHours - $activity->hours;

                if ( $missingActivity->hours > 0 ) {
                    $missingActivity->save();
                }
                else {
                    $missingActivity->forceDelete();
                }
            }
        }

        /**
         * @param User $user
         *
         * @return bool
         */
        private function isCollaborator(User $user)
        {
            return $user->role->slug == 'collaborator';
        }

        /**
         * @param $events
         */
        public function subscribe($events)
        {
            $events->listen('Delos\Dgp\Events\ActivityOnWeekdayEvent', 'Delos\Dgp\Listeners\DeleteMissingActivityListener@handle');
        }
    }
