<?php

namespace Delos\Dgp\Console\Commands;

use Carbon\Carbon;
use Delos\Dgp\Entities\Event;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\Request;
use Delos\Dgp\Notifications\PusherTrait;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Mailer;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Translation\Translator;
use Illuminate\Mail\Message;


class RequestSummary extends Command
{
    use PusherTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:requests-summary {start : start day (of week) that will be used as a reference for the search requests} {finish : finish day (of week) that will be used as a reference for the search requests}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a requests summary email to Administrators from start to finish arguments';
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Translator
     */
    private $translator;
    /**
     * @var Request
     */
    private $request;

    public function __construct(Mailer $mailer, Config $config, Translator $translator, Request $request)
    {
        parent::__construct();
        $this->mailer = $mailer;
        $this->config = $config;
        $this->translator = $translator;
        $this->request = $request;
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

            $start = (new Carbon("last {$this->argument('start')}"))->startOfDay();
            $finish = (new Carbon("last {$this->argument('finish')}"))->endOfDay();

            $requests = $this->request
                ->onlyParents()
                ->whereBetween('created_at', [$start, $finish])
                ->whereHas('project.company', function (Builder $query) {
                    $query->whereIn('id', session('companies'));
                })
                ->get();

            $title = trans('subjects.request-made-between', ['start' => $start->format('d/m/Y'), 'finish' => $finish->format('d/m/Y')]);

            $data = compact('requests', 'start', 'finish', 'title');

            $this->mailer->send('emails.request-summary', $data, function (Message $message) use ($start, $finish, $data) {

                $subject = $this->translator->trans('subjects.advance-money-summary');
                $message->subject($subject);

                foreach ($this->getReceivers() as $receiver) {
                    $this->notify($receiver, $subject, "Solicitações realizadas entre {$start->format('d/m/Y')} e {$finish->format('d/m/Y')}", 'emails.request-summary', $data);

                    $message->to(env('TEST_DESTINATION_EMAIL'), $receiver['name']);
                }
            });
        }
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'request-summary')->get()->first()->users->all();
    }
}
