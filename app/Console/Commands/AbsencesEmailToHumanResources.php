<?php

namespace Delos\Dgp\Console\Commands;

use Carbon\Carbon;
use Delos\Dgp\Entities\Event;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Notifications\CommonNotification;
use Delos\Dgp\Notifications\PusherTrait;
use Delos\Dgp\Repositories\Contracts\ActivityRepository;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Translation\Translator;
use Illuminate\Mail\Message;
use Illuminate\Contracts\Config\Repository as Config;

class AbsencesEmailToHumanResources extends Command
{
    use PusherTrait;

    protected $signature = 'email:absences';
    protected $description = 'Send email to human resources about absences created since last monday';
    private $mailer;
    private $translator;
    private $config;
    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    public function __construct(Mailer $mailer, Translator $translator, Config $config)
    {
        parent::__construct();

        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->config = $config;
        $this->activityRepository = app(ActivityRepository::class);
    }

    public function handle()
    {
        foreach (app(GroupCompany::class)->all() as $groupCompany) {

            session(['groupCompanies' => $groupCompany->id]);
            session(['companies' => $groupCompany->companies()->pluck('id')->toArray()]);

            $lastMonday = new Carbon('last monday');
            $absences = $this->activityRepository->getAbsencesCreatedSinceLastMonday();

            $humanResources = $this->getHumanResources();

            foreach ($humanResources as $humanResource) {
                $data = compact('absences', 'lastMonday', 'humanResource');
                $userNotify = $humanResource->getAttributes();
                $humanResource['email_title'] = $this->translator->trans('subjects.absences');
                unset($userNotify['avatar']);


                $this->notify($humanResource, 'Verifique se há atividades com a tarefa ausência', "Podem haver atividades com tarefas ausências", 'emails.absences', $data);

                $this->mailer->send('emails.absences', $data, function (Message $m) use($humanResource) {
                    $m->to($humanResource['email'], $humanResource['name']);
                    $m->subject($this->translator->trans('subjects.absences'));
                });
            }
        }
    }

    private function getHumanResources(): array
    {
        $humanResources = [];

        if (app(Event::class)->getUsersByCompanies(session('companies'))->where('name', 'absences')->get()->count() > 0) {
            $humanResources = app(Event::class)->getUsersByCompanies(session('companies'))->where('name', 'absences')->get()->first()->users->all();
        }
        return $humanResources;
    }
}
