<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Events\CreatedRequestEvent;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class ApproveRequestEmail implements ShouldQueue
{

    private $translator;
    private $mailer;
    private $config;

    public function __construct(Mailer $mailer, Translator $translator, Config $config)
    {
        $this->translator = $translator;
        $this->mailer = $mailer;
        $this->config = $config;
    }

    public function handle(CreatedRequestEvent $event)
    {
        $request = $event->request;
        $requester = $request->requester;

        foreach ($this->getReceivers() as $receiver) {
            $responsibleName = $receiver['name'];
            $title = trans('subjects.approve-request');

            $this->mailer->send('emails.approve-request', compact('request', 'responsibleName', 'title'), function (Message $message) use($requester, $receiver) {

                $subject = $this->translator->trans('subjects.approve-request');
                $message->subject($subject);

                $responsible = $receiver;

                $message->to($responsible['email'], $responsible['name']);

                if($responsible['email'] !== $requester->email) {
                    $message->cc($requester->email, $requester->name);
                }
            });
        }
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'approve-request')->get()->first()->users->toArray();
    }
}