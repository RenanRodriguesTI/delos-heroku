<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Events\DeleteProjectEvent;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class SendEmailWhenProjectIsRemoved implements ShouldQueue
{
    private $mailer;
    private $translator;
    private $config;

    public function __construct(Mailer $mailer, Translator $translator, Config $config)
    {
        $this->translator = $translator;
        $this->mailer = $mailer;
        $this->config = $config;
    }

    /**
     * Handle the event.
     *
     * @param  DeleteProjectEvent  $event
     * @return void
     */
    public function handle(DeleteProjectEvent $event)
    {
        $project = $event->project;
        $title   = trans('subjects.project-details');

        $this->mailer->send('emails.deleted-project', compact('project', 'title'), function(Message $message) use ($project) {
            $subject = $this->translator->trans('subjects.send-email-when-project-is-removed');

            foreach($project->members as $member) {
                $message->to($member->email, $member->name);
            }

            foreach($this->getReceivers() as $receiver) {
                $message->cc($receiver['email'], $receiver['name']);
            }

            $message->subject($subject);
        });
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'complete-project')->get()->first()->users->toArray();
    }
}
