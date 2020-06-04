<?php

namespace Delos\Dgp\Console\Commands;

use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Notifications\CommonNotification;
use Delos\Dgp\Notifications\PusherTrait;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class SendMissingMembersActivitiesEmailsToOwner extends Command
{
    use PusherTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:missing-members-activities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to project owner with missing members activities';
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Mailer $mailer, Translator $translator)
    {
        parent::__construct();
        $this->projectRepository = app(ProjectRepository::class);
        $this->userRepository = app(UserRepository::class);
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

            $projects = $this->projectRepository->all();

            foreach ($projects as $project) {

                $members = $this->userRepository
                    ->getCollaboratorsAndCoLeaderByProjectId($project->id);


                $totalHours = $this->getTotalMissingHoursOfMembers($members);
                $totalDays = $this->getTotalMissingDaysOfMembers($members);

                if ($totalHours) {
                    $data = compact('project', 'totalHours', 'totalDays', 'members');

                    $this->notify($project->owner, 'Atividade Faltantes para o projeto: ' . $project->compiled_cod, "Há colaboradores que não atualizaram a alocação a Projetos, <br> podem ser pendências em projetos que você lidera.", 'emails.missing-activities-leader', $data);

                    $this->sendEmail($data, $project);
                }

            }
        }
    }

    private function sendEmail($viewData, Project $project)
    {
        $this->mailer
            ->send('emails.missing-activities-leader', $viewData, function (Message $message) use ($project) {
                $owner = $project->owner;

                $subject = $this->translator->trans('subjects.notifications');
                $subject .= " - $project->full_description";

                $message->to(env('TEST_DESTINATION_EMAIL'), $owner->name)
                    ->subject($subject);
            });
    }

    private function getTotalMissingHoursOfMembers($members)
    {
        $totalHours = 0;

        foreach ($members as $member) {

            $this->throwsAnExceptionIfNotUser($member);
            $totalHours += $member->missingActivities->sum('hours');
        }

        return $totalHours;

    }

    private function getTotalMissingDaysOfMembers($members)
    {
        $totalDays = 0;

        foreach ($members as $member) {
            $this->throwsAnExceptionIfNotUser($member);
            $totalDays += $member->missingActivities->count();
        }

        return $totalDays;
    }

    private function throwsAnExceptionIfNotUser($user)
    {
        if(!$user instanceof User) {
            throw new \InvalidArgumentException('User instance was expected');
        }
    }
}
