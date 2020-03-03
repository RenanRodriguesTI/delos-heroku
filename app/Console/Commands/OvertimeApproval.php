<?php

namespace Delos\Dgp\Console\Commands;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Notifications\PusherTrait;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Translation\Translator as Trans;

class OvertimeApproval extends Command
{
    use PusherTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:overtime-approval';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to approve collaborators overtime to the owner';
    /**
     * @var ProjectRepository
     */
    protected $projectRepository;
    /**
     * @var Mailer
     */
    protected $mailer;
    /**
     * @var Trans
     */
    protected $trans;
    /**
     * @var Config
     */
    private $config;

    public function __construct(ProjectRepository $project, Mailer $mailer, Trans $trans, Config $config)
    {
        parent::__construct();
        $this->projectRepository = $project;
        $this->mailer = $mailer;
        $this->trans = $trans;
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

            session(['groupCompanies' => $groupCompany->id]);
            session(['companies' => $groupCompany->companies()->pluck('id')->toArray()]);

            $projects = $this->projectRepository->all();

            foreach($projects as $project) {
                $activities = $project->activities()
                    ->where('approved', false)
                    ->get();

                if($activities->count()) {
                    $owner = $project->owner;

                    $this->notify($owner, 'Existem horas para serem aprovadas', 'Foi identificado alguma(s) atividade(s) para ser(em) aprovada(s)', 'emails.approve-activities', compact('activities'));

                    $this->mailer
                        ->send('emails.approve-activities', compact('activities'), function(Message $message) use($owner) {

                            $subject = $this->trans->trans('subjects.overtime-approval');
                            $message->subject($subject);

                            $message->to($owner->email, $owner->name);

                            foreach($this->getReceivers() as $receiver) {
                                $message->cc($receiver['email'], $receiver['name']);
                            }
                        });
                }
            }
        }
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'approve-activities')->get()->first()->users->toArray();
    }
}