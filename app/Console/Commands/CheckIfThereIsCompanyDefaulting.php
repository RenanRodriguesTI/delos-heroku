<?php

namespace Delos\Dgp\Console\Commands;

use Carbon\Carbon;
use Delos\Dgp\Entities\Company;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\PaymentTransaction;
use Delos\Dgp\Http\Controllers\SignaturesController;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class CheckIfThereIsCompanyDefaulting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signature:defaulting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '** To run every day ** Verify there is some defaulted company';
    /**
     * @var GroupCompanyRepository
     */
    private $company;
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Create a new command instance.
     * @param GroupCompanyRepository $groupCompany
     * @param Mailer $mailer
     */
    public function __construct(GroupCompanyRepository $groupCompany, Mailer $mailer)
    {
        parent::__construct();
        $this->company = $groupCompany;
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach (app(GroupCompany::class)->all() as $groupCompany) {

            session(['groupCompanies' => [$groupCompany->id]]);
            session(['companies' => $groupCompany->companies()->pluck('id')->toArray()]);

            $bar = $this->output->createProgressBar(count($this->company->all()->count()));

            $this->company
                ->all()
                ->each(function ($item, $key) use ($bar) {

                    if ($this->isPast7DaysWhenBankSlipGenerated($item) || $this->isTrialPeriod($item)) {

                        $item->update([
                            'is_defaulting' => true,
                        ]);

                        if ($this->isPast7DaysWhenBankSlipGenerated($item)) {

                            $transaction = $this->getLastTransactionFromCompany($item);

                            $transaction->update([
                                'status' => SignaturesController::TRANSFER_CANCELED
                            ]);

                            $this->mailer->send('emails.transfer_canceled', compact('transaction'), function (Message $message) use ($item) {
                                $message->priority(5);
                                $message->to(env('TEST_DESTINATION_EMAIL'), $item->paymentInformation->name);
                                $message->subject('Boleto Vencido');
                            });

                            $item->update([
                                'plan_status' => false
                            ]);
                        }

                    }

                    $bar->advance();
                });

            $bar->finish();
        }
    }

    /**
     * @return mixed
     */
    private function getHolidays()
    {
        $holidays = app(HolidayRepository::class)
            ->pluck('date')
            ->map(function (Carbon $item) {
                return $item->format('Y-m-d');
            });
        return $holidays;
    }

    /**
     * @param GroupCompany $item
     * @return int
     */
    private function getDiffDaysFromSignatureDay(GroupCompany $item) : ?int
    {
        $now = Carbon::now();
        $diff = $item->signature_date->diffInDays($now);

        return $diff;
    }

    /**
     * @param GroupCompany $company
     * @return PaymentTransaction
     */
    private function getLastTransactionFromCompany(GroupCompany $company) : ?PaymentTransaction
    {
        return $company->paymentTransactions()
            ->orderBy('id', 'desc')
            ->first() ?? null;
    }

    /**
     * Check is in trial period
     * @param GroupCompany $company
     * @return bool
     * @internal param int $diffDays
     */
    public function isTrialPeriod(GroupCompany $company): bool
    {
        $diffDays = $this->getDiffDaysFromSignatureDay($company);

        return $diffDays >= $company->plan->trial_period;
    }

    /**
     * @param Company|GroupCompany $company
     * @return bool
     */
    public function isPast7DaysWhenBankSlipGenerated(GroupCompany $company): bool
    {
        $diffDays = $this->getDiffDaysFromBillingDate($company);
        $transaction = $this->getLastTransactionFromCompany($company);

        if (!$transaction) {
            false;
        }

        return $diffDays >= 7
            && $transaction->status == SignaturesController::AWAITING_PAYMENT;
    }

    /**
     * @param GroupCompany $item
     * @return int
     */
    private function getDiffDaysFromBillingDate(GroupCompany $item) : ?int
    {
        $lastTransaction = $this->getLastTransactionFromCompany($item);
        $holidays = $this->getHolidays();
        $now = Carbon::now();
        $diff = 0;

        if (!is_null($lastTransaction)) {
            $diff = $lastTransaction->billing_date->diffInDaysFiltered(function (Carbon $date) use ($holidays) {
                    return !!$date->isWeekend() || (!$date->isWeekend() && !$holidays->contains($date->format('Y-m-d')));
                }, $now)-1;
        }

        return $diff;
    }
}
