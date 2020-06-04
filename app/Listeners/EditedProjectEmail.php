<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Events\EditedProjectEvent;
use Illuminate\Config\Repository as Config;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

//This class cannot implement the interface "ShouldQueue",
// because a strange behavior when it comes to working with cloned objects
class EditedProjectEmail
{
    private $mailer;
    private $config;

    public function __construct(Mailer $mailer, Config $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }

    public function handle(EditedProjectEvent $event)
    {
        $editedProject   = $event->editedProject;
        $originalProject = $event->originalProject;
        $title           = trans('subjects.edited-project');

        $user = $event->authenticatedUser;

        $this->mailer

            ->send('emails.edited-project', compact('originalProject' ,'editedProject', 'user', 'title'), function (Message $message) use ($editedProject, $originalProject) {
                    //Modificação feita para teste não comitar essa classe
                   
                if ($editedProject->owner_id !== $originalProject->owner_id) {
                    $message->to(env('TEST_DESTINATION_EMAIL'), $editedProject->owner->name);
                    $message->to(env('TEST_DESTINATION_EMAIL'), $originalProject->owner->name);
                } else {
                    $message->to(env('TEST_DESTINATION_EMAIL'), $editedProject->owner->name);
                }

                if ($editedProject->co_owner_id != $originalProject->co_owner_id) {

                    if($editedProject->coOwner !== null) {
                        $message->to(env('TEST_DESTINATION_EMAIL'), $editedProject->coOwner->name);
                    }

                    if($originalProject->coOwner !== null) {
                        $message->to(env('TEST_DESTINATION_EMAIL'), $originalProject->coOwner->name);
                    }
                } else {
                    if($editedProject->coOwner !== null) {
                        $message->to(env('TEST_DESTINATION_EMAIL'), $editedProject->coOwner->name);
                    }
                }

                if ($editedProject->seller_id != null) {
                    $message->addCc(env('TEST_DESTINATION_EMAIL'), $editedProject->seller->name);
                }

                if ($editedProject->client_id != $originalProject->client_id) {

                    if($editedProject->client !== null) {
                        $message->to(env('TEST_DESTINATION_EMAIL'), $editedProject->client->name);
                    }

                    if($originalProject->client !== null) {
                        $message->to(env('TEST_DESTINATION_EMAIL'), $originalProject->client->name);
                    }
                } else {
                    if($editedProject->client !== null) {
                        $message->to(env('TEST_DESTINATION_EMAIL'), $editedProject->client->name);
                    }
                }

                foreach($this->getReceivers() as $receiver) {
                    $message->cc(env('TEST_DESTINATION_EMAIL'), $receiver['name']);
                }
                
                $subject = trans('subjects.edited-project');
                $message->subject($subject);

        });
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'edited-project')->get()->first()->users->toArray();
    }
}
