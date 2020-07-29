<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ImportedRevenuesListener
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
    public function handle($event)
    {
        $user = $event->user;


        $title = 'Importação de Faturamentos';

        $this->mailer->send('emails.imported-revenues',compact('title'),function(Message $message) use($user,$title){
            $message->to($user->email,$user->name);
            $message->subject($title);
        });
    }
}
