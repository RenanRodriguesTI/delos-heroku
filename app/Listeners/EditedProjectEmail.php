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

                if ($editedProject->owner_id !== $originalProject->owner_id) {
                    $message->to($editedProject->owner->email, $editedProject->owner->name);
                    $message->to($originalProject->owner->email, $originalProject->owner->name);
                } else {
                    $message->to($editedProject->owner->email, $editedProject->owner->name);
                }

                if ($editedProject->co_owner_id != $originalProject->co_owner_id) {

                    if($editedProject->coOwner !== null) {
                        $message->to($editedProject->coOwner->email, $editedProject->coOwner->name);
                    }

                    if($originalProject->coOwner !== null) {
                        $message->to($originalProject->coOwner->email, $originalProject->coOwner->name);
                    }
                } else {
                    if($editedProject->coOwner !== null) {
                        $message->to($editedProject->coOwner->email, $editedProject->coOwner->name);
                    }
                }

                if ($editedProject->seller_id != null) {
                    $message->addCc($editedProject->seller->email, $editedProject->seller->name);
                }

                if ($editedProject->client_id != $originalProject->client_id) {

                    if($editedProject->client !== null) {
                        $message->to($editedProject->client->email, $editedProject->client->name);
                    }

                    if($originalProject->client !== null) {
                        $message->to($originalProject->client->email, $originalProject->client->name);
                    }
                } else {
                    if($editedProject->client !== null) {
                        $message->to($editedProject->client->email, $editedProject->client->name);
                    }
                }

                foreach($this->getReceivers() as $receiver) {
                    $message->cc($receiver['email'], $receiver['name']);
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
