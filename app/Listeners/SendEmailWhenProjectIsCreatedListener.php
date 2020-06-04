<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Events\CreatedProjectEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class SendEmailWhenProjectIsCreatedListener implements ShouldQueue
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(CreatedProjectEvent $event) : void
    {
        $project = $event->project;
        $title   = trans('subjects.created-project');

        $this->mailer->send('emails.created-project', compact('project', 'title'), function (Message $message) use ($project) {

            $message->to(env('TEST_DESTINATION_EMAIL'), $project->owner->name);

            // if ($project->co_owner_id != null) {
            //     $message->to($project->coOwner->email, $project->coOwner->name);
            // }

            // if ($project->seller_id != null) {
            //     $message->addCc($project->seller->email, $project->seller->name);
            // }

            // if ($project->client != null) {
            //     $message->to($project->client->email, $project->client->name);
            // }

            // foreach ($this->getReceivers() as $receiver) {
            //     $message->cc($receiver['email'], $receiver['name']);
            // }
            $subject = trans('subjects.created-project');
            $message->subject($subject);

        });
    }

    private function getReceivers()
    {
        return app(Event::class)
            ->where('name', 'created-project')
            ->get()
            ->first()
            ->users->
            toArray();
    }
}
