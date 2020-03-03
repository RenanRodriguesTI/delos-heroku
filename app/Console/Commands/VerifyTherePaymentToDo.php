<?php

namespace Delos\Dgp\Console\Commands;

use Carbon\Carbon;
use Delos\Dgp\Entities\PaymentTransaction;
use Delos\Dgp\Events\BillingToDo;
use Delos\Dgp\Http\Controllers\SignaturesController;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Illuminate\Console\Command;
use \Illuminate\Support\Collection;

class VerifyTherePaymentToDo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signature:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '** To run every day ** Verify for there payment to do in that day';
    /**
     * @var PaymentTransaction
     */
    private $transaction;
    /**
     * @var GroupCompanyRepository
     */
    private $companyRepository;

    /**
     * Create a new command instance.
     * @param PaymentTransaction $transaction
     * @param GroupCompanyRepository $companyRepository
     */
    public function __construct(PaymentTransaction $transaction, GroupCompanyRepository $companyRepository)
    {
        parent::__construct();
        $this->transaction = $transaction;
        $this->companyRepository = $companyRepository;
    }

    public function handle()
    {
        $companiesToBeCharged = collect();

        $this->getCompaniesToBeCharged($companiesToBeCharged);
        $this->if30thGetCorrectDates($companiesToBeCharged);
        $this->ifFebruaryGetCorrectDates($companiesToBeCharged);

        $bar = $this->output->createProgressBar(count($companiesToBeCharged));

        foreach ($companiesToBeCharged as $company) {
            session(['groupCompanies' => $company->id]);
            session(['companies' => $company->companies()->pluck('id')->toArray()]);

            if ($this->isValidToCharge($company)) {
                $transaction = $this->createTransaction($company);
                event(new BillingToDo(null, $transaction));
            }

            $bar->advance();
        }

        $bar->finish();
    }

    private function if30thGetCorrectDates(Collection $companiesToBeCharged): void
    {
        $now = Carbon::now();
        $dateToCheck = $now->copy();
        if ($now->day == 30 && $dateToCheck->addDay()->day !== 31) {
            $this->companyRepository
                ->makeModel()
                ->where(\DB::raw("day(billing_date)"), 31)
                ->get()
                ->each(function ($item, $key) use ($companiesToBeCharged) {
                    $companiesToBeCharged->push($item);
                });
        }
    }

    private function ifFebruaryGetCorrectDates(Collection $companiesToBeCharged): void
    {
        $now = Carbon::now();
        $dateToCheck = $now->copy();
        if ($now->month == 2) {
            $query = $this->companyRepository->makeModel();

            if ($dateToCheck->addDay()->day !== 29) {
                $query->where(\DB::raw("day(billing_date)"), 29);
            }

            $query->where(\DB::raw("day(billing_date)"), 30)
                ->where(\DB::raw("day(billing_date)"), 31)
                ->get()
                ->each(function ($item, $key) use ($companiesToBeCharged) {
                    $companiesToBeCharged->push($item);
                });
        }
    }

    private function getCompaniesToBeCharged(Collection $companiesToBeCharged): void
    {
        $this->companyRepository
            ->makeModel()
            ->where(\DB::raw("day(billing_date)"), \DB::raw("day(now())"))
            ->get()
            ->each(function ($item, $key) use ($companiesToBeCharged) {
                $companiesToBeCharged->push($item);
            });
    }

    private function createTransaction($company): PaymentTransaction
    {
        $transaction = $this->transaction->create([
            'billing_date' => Carbon::now(),
            'status' => SignaturesController::GENERATING_BANK_SLIP,
            'value_paid' => $company->plan->value * $company->users->count(),
            'group_company_id' => $company->id,
        ]);
        return $transaction;
    }

    private function isValidToCharge($company): bool
    {
        $lastTransaction = $company->paymentTransactions->last();

        return $lastTransaction->billing_date->addMonth() !== Carbon::now()->month
            && $lastTransaction->status == SignaturesController::PAID_OUT
            && $company->plan_status;
    }
}
