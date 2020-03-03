<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Events\ApprovedRequestEvent;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class SendEmailWhenRequestIsCreatedListener implements ShouldQueue
{
    /**
     * @var Translator
     */
    private $translator;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Config
     */
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
     * @param  ApprovedRequestEvent  $event
     * @return void
     */
    public function handle(ApprovedRequestEvent $event)
    {
        $request = $event->request;
        $title   = trans('subjects.request-creation', ['full_description' => $request->project->full_description, 'start' => $request->start->format('d/m/Y'), 'finish' => $request->finish->format('d/m/Y')]);

        $this->mailer->send('emails.requests', ['request' => $request, 'title' => $title], function (Message $message) use ($request) {

            $project = $request->project;

            foreach($request->users as $user) {
                $message->to($user->email, $user->name);
            }

            //if owner is not part of this request
            if($request->users()->where('id', $project->owner->id)->first() == null) {
                $message->cc($project->owner->email, $project->owner->name);
            }

            //if co-owner is not part of this request
            if($project->coOwner != null && $request->users()->where('id', $project->coOwner->id)->first() == null) {
                $message->cc($project->coOwner->email, $project->coOwner->name);
            }

            foreach($this->getReceivers() as $receiver) {
                $message->cc($receiver['email'], $receiver['name']);
            }

            $subject = $this->translator->get('subjects.created-request');
            $message->subject($subject);
        });
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'created-request')->get()->first()->users->toArray();
    }
}
