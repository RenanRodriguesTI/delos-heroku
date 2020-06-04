<?php

namespace Delos\Dgp\Listeners;

use Carbon\Carbon;
use Delos\Dgp\Events\RefusedRequestEvent;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class RefusedRequestEmail implements ShouldQueue
{

    private $mailer;
    private $translator;
    private $config;

    public function __construct(Mailer $mailer, Translator $translator, Config $config)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->config = $config;
    }

    /**
     * Handle the event.
     *
     * @param  RefusedRequestEvent  $event
     * @return void
     */
    public function handle(RefusedRequestEvent $event)
    {
        $request    = $event->request;
        $reason     = $event->reason;
        $rejector   = $event->authenticatedUser;
        $title      = trans('subjects.refused-request');

        $now = Carbon::now();
        $data = compact('request', 'reason', 'rejector', 'now', 'title');

        $this->mailer->send('emails.refused-request', $data, function (Message $message) use($request, $rejector) {

            $message->cc($rejector->email, $rejector->name);

            $owner = $request->project->owner;

            
            //Não comitar esse arquivo
            $message->to(env('TEST_DESTINATION_EMAIL'), $owner->name);
            $coOwner = $request->project->coOwner;

            if($coOwner !== null) {
                $message->cc(env('TEST_DESTINATION_EMAIL'), $coOwner->name);
            }

            $subject = $this->translator->trans('subjects.refused-request');
            $message->subject($subject);
        });
    }
}
