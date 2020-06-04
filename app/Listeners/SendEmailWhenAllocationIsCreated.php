<?php

    namespace Delos\Dgp\Listeners;

    use Delos\Dgp\Events\SavedAllocation;
    use Illuminate\Mail\Mailer;
    use Illuminate\Mail\Message;
    use Illuminate\Support\Facades\Auth;

    class SendEmailWhenAllocationIsCreated
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
         * @param  SavedAllocation $event
         *
         * @return void
         */
        public function handle(SavedAllocation $event)
        {
            $allocation       = $event->allocation;
            $user             = Auth::user();
            $title            = "Você foi alocado para o projeto: {$allocation->project->compiled_cod}, por {$user->name}";
            $credentialsTitle = "Dados da alocação";


            $this->mailer->send('emails.created-allocation', compact('allocation', 'title', 'credentialsTitle'), function (Message $message) use ($title, $allocation) {
                if($allocation->task_id){
                    $message->to(env('TEST_DESTINATION_EMAIL'), $allocation->user->name);
                }
                
                $message->cc(env('TEST_DESTINATION_EMAIL_2'), $allocation->project->owner->name);
                
                if ( $allocation->project->coOwner != null ) {
                    $message->cc(env('TEST_DESTINATION_EMAIL_2'), $allocation->project->coOwner->name);
                }

                $message->subject($title);
            });
        }
    }
