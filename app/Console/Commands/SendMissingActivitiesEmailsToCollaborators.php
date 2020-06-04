<?php

namespace Delos\Dgp\Console\Commands;

use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Notifications\PusherTrait;
use Delos\Dgp\Repositories\Contracts\MissingActivityRepository;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class SendMissingActivitiesEmailsToCollaborators extends Command
{
    use PusherTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:missing-collaborators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to collaborators about their missing activities';
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var MissingActivityRepository
     */
    protected $missingActivityRepo;
    /**
     * @var Mailer
     */
    protected $mailer;
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Mailer $mailer, Translator $translator)
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->missingActivityRepo = app(MissingActivityRepository::class);

        $this->mailer = $mailer;
        $this->translator = $translator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (app(GroupCompany::class)->all() as $groupCompany) {

            session(['groupCompanies' => [$groupCompany->id]]);
            session(['companies' => $groupCompany->companies()->pluck('id')->toArray()]);

            $collaborators = $this->userRepository->getCollaborators();

            foreach($collaborators as $collaborator) {

                $days = $this->missingActivityRepo
                    ->countHoursByUserId($collaborator->id);
                if($days) {

                    $hours = $this->missingActivityRepo
                        ->sumHoursByUserId($collaborator->id);

                    $title = trans('subjects.missing-activities');

                    $data = array_merge(compact('days', 'hours', 'title'), ['collaborator' => $collaborator->name]);

                    $this->notify($collaborator, $this->translator
                        ->trans('subjects.missing-activities'), 'Identificamos que você tem horas pendentes', 'emails.missing-activities', $data);
                    
                    $this->sendEmail($data, $collaborator);
                }
            }
        }
    }

    private function sendEmail(array $viewData, User $collaborator)
    {
        $this->mailer
            ->send('emails.missing-activities', $viewData, function (Message $message) use ($collaborator) {

                $subject = $this->translator
                    ->trans('subjects.missing-activities');

                $message->to(env('TEST_DESTINATION_EMAIL'), $collaborator->name)->subject($subject);
            });
    }
}
