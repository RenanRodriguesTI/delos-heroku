<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\DeleteActivityEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class RefusedActivityEmail implements ShouldQueue
{
    public function handle(DeleteActivityEvent $event)
    {
        $activity = $event->activity;

        if ($activity->approved || !$activity->weekend) return;

        $responsible = $event->authenticatedUser;
        $subject = trans('subjects.refused-activity');

        Mail::send(
            'emails.refused-activity',
            [
                'activity' => $activity,
                'responsibleName' => $responsible->name,
                'subject' => $subject
            ],
            function (Message $message) use ($activity, $subject) {

                //Modificação feita para teste não comitar essa classe
            $message->to(env('TEST_DESTINATION_EMAIL'), $activity->user->name)->subject($subject);
                // $message->to($activity->user->email, $activity->user->name)
                //     ->subject($subject);
            });
    }
}
