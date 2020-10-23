<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;

class SendEmailWhenAllocationIsUpdated
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
        $allocation       = $event->allocation;
        $user             = Auth::user();
        $title            = "Sua alocação para o projeto: {$allocation->project->compiled_cod}, foi atualizada por {$user->name}";
        $credentialsTitle = "Dados da alocação";


        $this->mailer->send('emails.created-allocation', compact('allocation', 'title', 'credentialsTitle'), function (Message $message) use ($title, $allocation) {
            if($allocation->task_id || !$allocation->allocationTasks->isEmpty()){
                $message->to( $allocation->user->email, $allocation->user->name);
            } else{
                if($allocation->project->owner->email == $allocation->user->email){
                    $message->to($allocation->project->owner->email, $allocation->project->owner->name);
                }   
            }
            
            $message->cc($allocation->project->owner->email, $allocation->project->owner->name);
            
            if ( $allocation->project->coOwner != null ) {
                $message->cc($allocation->project->coOwner->email, $allocation->project->coOwner->name);
            }

            $message->subject($title);
        });
    }
}
