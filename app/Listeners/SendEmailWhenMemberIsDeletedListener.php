<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\DeletedMemberEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;
use Delos\Dgp\Repositories\Contracts\UserRepository;

class SendEmailWhenMemberIsDeletedListener implements ShouldQueue
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
     * @param  DeletedMemberEvent  $event
     * @return void
     */
    public function handle(DeletedMemberEvent $event)
    {
        $member = $this->userRepository->skipCriteria()->find($event->memberId);

        $data = [
            'member' => $member,
            'project' => $event->project,
            'title' => trans('subjects.send-email-when-member-is-deleted-listener')
        ];

        $this->mailer->send('emails.deleted-member', $data, function(Message $message) use ($member) {
            $subject = $this->translator->trans('subjects.send-email-when-member-is-deleted-listener');
            $message->to(env('TEST_DESTINATION_EMAIL'), $member->name)
                ->subject($subject);
        });
    }
}
