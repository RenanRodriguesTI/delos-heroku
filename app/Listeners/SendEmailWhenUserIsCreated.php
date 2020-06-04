<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\CreatedUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class SendEmailWhenUserIsCreated implements ShouldQueue
{
    private $mailer;
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Mailer $mailer, Translator $translator)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
    }

    /**
     * Handle the event.
     *
     * @param  CreatedUserEvent  $event
     * @return void
     */
    public function handle(CreatedUserEvent $event)
    {
        $user               = $event->user;
        $password           = $event->password;
        $title              = trans('subjects.title-of-email-when-members-is-created', ['name' => $user->name, 'email' => $user->email]);
        $credentialsTitle   = trans('events.access-credentials');

    
        $this->mailer->send('emails.created-user', compact('user', 'password', 'title', 'credentialsTitle'), function (Message $message) use ($user) {
            $message->to(env('TEST_DESTINATION_EMAIL'), $user->name);

            $subject = $this->translator->trans('subjects.created-user');
            $message->subject($subject);
        });
    }
}
