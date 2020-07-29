<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\AddedMemberEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;
use Delos\Dgp\Repositories\Contracts\UserRepository;

class SendEmailWhenMemberIsCreatedListener implements ShouldQueue
{
    private $mailer;
    private $translator;
    private $userRepository;

    public function __construct(Mailer $mailer, Translator $translator)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * Handle the event.
     *
     * @param  AddedMemberEvent  $event
     * @return void
     */
    public function handle(AddedMemberEvent $event)
    {
        $member = $this->userRepository->find($event->memberId);
        $member->subject = trans('subjects.send-email-when-members-is-created-listener');

        $data = [
            'member' => $member,
            'project' => $event->project
        ];

        $this->mailer->send('emails.added-member', $data, function (Message $message) use ($member) {
            $subject = $this->translator->trans('subjects.send-email-when-members-is-created-listener');
            $message->to($member->email, $member->name)
                ->subject($subject);
        });
    }
}
