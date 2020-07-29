<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\NotifyToPaPAllocations;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class SendEmailAlocationsToPap
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    private $mailer;
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotifyToPaPAllocations $event)
    {
        $emailTopap = env('TEST_DESTINATION_EMAIL_2');
        $allocation = $event->allocation;
        $user = Auth::user();
        $title = "A alocação do projeto: {$allocation->project->compiled_cod} foi editada, por {$user->name}";
        $credentialsTitle = 'Dados da Alocação';


        $this->mailer->send('emails.created-allocation',compact('allocation', 'title', 'credentialsTitle'), function(Message $message) use ($title, $allocation,$emailTopap ) {
            $message->to($emailTopap,'ANA CAROLINA CALVETI' );

            $message->subject($title);
        });
    }
}
