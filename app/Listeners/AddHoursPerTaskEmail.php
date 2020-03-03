<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 27/04/17
 * Time: 16:44
 */

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Events\CreatedProjectEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class AddHoursPerTaskEmail implements ShouldQueue
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(CreatedProjectEvent $event) {
        $project = $event->project;
        $project->emailTitle = trans('events.created-project-add-hours-per-task');

        $this->mailer->send('emails.add-hours-per-task', ['project' => $project], function (Message $message) use ($project) {

            foreach($this->getReceivers() as $receiver) {
                $message->to($receiver['email'], $receiver['name']);
            }

            $subject = "Existe(m) tarefa(s) para adicionar hora(s)";
            $message->subject($subject);

        });
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'created-project-add-hours-per-task')->get()->first()->users->toArray();
    }
}