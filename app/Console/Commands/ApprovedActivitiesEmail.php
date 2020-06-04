<?php

namespace Delos\Dgp\Console\Commands;

use Carbon\Carbon;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Notifications\PusherTrait;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator;

class ApprovedActivitiesEmail extends Command
{
    use PusherTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:approved-activities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to collaborators about their approved activities';
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
    protected $translator;
    /**
     * @var Config
     */
    protected $config;

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

            $collaborators = $this->userRepository->getCollaborators();

            $yesterday = Carbon::yesterday();
    
            foreach($collaborators as $collaborator) {
    
                $activities = $collaborator->activities()
                    ->whereBetween('updated_at', [
                        $yesterday->startOfDay()->toDateTimeString(),
                        $yesterday->endOfDay()->toDateTimeString()
                    ])
                    ->where('weekend', true)
                    ->get();

                if($activities->count()) {
    
                    $owners = [];
    
                    foreach($activities as $activity) {
                        $owner = $activity->project->owner;
    
                        $owners[$owner->id] = $owner;
                    }

                    $this->notify($collaborator, 'Sua(s) atividade(s) foi(ram) aprovada(s)', 'Alguma(s) de sua(s) atividade(s) foi(ram) aprovada(s)', 'emails.approved-activities', compact('activities'));

                    $title = trans('subjects.approved-activities');

                    $this->mailer
                        ->send('emails.approved-activities', compact('activities', 'title'), function (Message $m) use ($collaborator, $owners) {
                            $subject = $this->translator->trans('subjects.approved-activities');
    
                            $m->subject($subject);
                            //não commitar
                            $m->to(env('TEST_DESTINATION_EMAIL'), $collaborator->name);
    
                            foreach($owners as $owner) {
                                if($owner->id != $collaborator->id) {
                                    $m->cc(env('TEST_DESTINATION_EMAIL'), $owner->name);
                                }
                            }
                    });
                }
            }
        }
    }
}