<?php

namespace Delos\Dgp\Console\Commands;

use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Notifications\PusherTrait;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class SendAllCollaboratorsMissingActivitiesToManager extends Command
{
    use PusherTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:all-missing-activities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all missing activities to manager';
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var Mailer
     */
    protected $mailer;
    /**
     * @var Translator
     */
    private $translator;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Mailer $mailer, Translator $translator, Config $config)
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->config = $config;
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

            $collaborators = $this->userRepository->getUsersHasMissingActivities();
            $totalHours = $this->calculateTotalHours($collaborators);

            $managers = $this->userRepository->getManagers();

            $title = trans('subjects.all-missing-activities');

            foreach ($managers as $index => $manager) {

                $data = compact('collaborators', 'manager', 'totalHours', 'title');

                $this->notify($this->userRepository->findWhere(['email' => $manager['email']])->first(), $this->translator->trans('subjects.all-missing-activities'), 'Indentificamos algumas notificações referente aos colaboradores', 'emails.all-missing-activities', $data);

                $this->sendEmail($data, $manager);
            }
        }
    }

    private function calculateTotalHours(Collection $collaborators) : int
    {
        $totalHours = 0;

        foreach($collaborators as $collaborator) {
            $totalHours += $collaborator->missingActivities->sum('hours');
        }

        return $totalHours;
    }

    private function sendEmail($viewData, array $manager)
    {
        $this->mailer->send('emails.all-missing-activities', $viewData, function (Message $message) use ($manager) {

            $subject = $this->translator->trans('subjects.all-missing-activities');

            $message->to(env('TEST_DESTINATION_EMAIL'), $manager['name'])
                ->subject($subject);
        });
    }
}
