<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\DeletedAllocation;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class SendEmailWhenAllocationIsDeleted
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Create the event listener.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  DeletedAllocation  $event
     * @return void
     */
    public function handle(DeletedAllocation $event)
    {
        $allocation       = $event->allocation;
        $user             = Auth::user();
        $title            = "A(O) {$user->name} acabou de excluir a sua alocação do dia {$allocation->start->format('d/m/Y')} ao dia {$allocation->finish->format('d/m/Y')}";
        $credentialsTitle = "Veja abaixo qual foi a razão da exclusão";


        $this->mailer->send('emails.deleted-allocation', compact('allocation', 'title', 'credentialsTitle'), function (Message $message) use ($title, $allocation) {
            $message->to($allocation->user->email, $allocation->user->name);
            $message->cc($allocation->project->owner->email, $allocation->project->owner->name);

            if ( $allocation->project->coOwner != null ) {
                $message->cc($allocation->project->coOwner->email, $allocation->project->coOwner->name);
            }

            $message->subject($title);
        });
    }
}
