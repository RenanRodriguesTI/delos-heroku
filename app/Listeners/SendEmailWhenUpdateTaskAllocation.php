<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Delos\Dgp\Events\UpdateTaskAllocation;

class SendEmailWhenUpdateTaskAllocation
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
    public function handle(UpdateTaskAllocation $event)
    {
        $allocation       = $event->allocation;
        $taskupdated =  $event->task;
        $user             = Auth::user();
        $title            = "Foi atualizada a tarefa {$taskupdated} na alocação do projeto: {$allocation->project->compiled_cod}, por {$user->name}";
        $credentialsTitle = "Dados da alocação";


        $this->mailer->send('emails.add-task-allocation', compact('allocation', 'title', 'credentialsTitle'), function (Message $message) use ($title, $allocation) {
            if($allocation->task_id || !$allocation->allocationTasks->isEmpty()){
                $message->to( $allocation->user->email, $allocation->user->name);
            }
            
            if($allocation->project->owner->email != $allocation->user->email){
                $message->cc($allocation->project->owner->email, $allocation->project->owner->name);
            }   else{
                $message->to($allocation->project->owner->email, $allocation->project->owner->name);
            }

            if ( $allocation->project->coOwner != null ) {
                $message->cc($allocation->project->coOwner->email, $allocation->project->coOwner->name);
            }

            $message->subject($title);
        });
    }
}
