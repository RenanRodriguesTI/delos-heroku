<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 16/10/17
 * Time: 09:40
 */

namespace Delos\Dgp\Http\Controllers;

use Carbon\Carbon;
use Delos\Dgp\Entities\PaymentTransaction;
use Delos\Dgp\Repositories\Contracts\PlanRepository;

class SignaturesController extends Controller
{
    public const AWAITING_PAYMENT = 'AGUARDANDO PAGAMENTO';
    public const CANCELED_SIGNATURE = 'ASSINATURA CANCELADA';
    public const GENERATING_BANK_SLIP = 'GERANDO BOLETO';
    public const TRANSFER_CANCELED = 'TRANSAÇÃO CANCELADA';
    public const PAID_OUT = 'PAGO';
    public const BEGINNING_TEST_PERIOD = 'INÍCIO DO PERÍODO DE TESTE';

    private $planRepository;
    private $paymentTransaction;

    public function __construct(PlanRepository $repository, PaymentTransaction $paymentTransaction)
    {
        $this->planRepository = $repository;
        $this->paymentTransaction = $paymentTransaction;
    }
    
    public function index() {
        $groupCompany = \Auth::user()->groupCompany;
        $transactions = $groupCompany->paymentTransactions()->orderBy('id', 'desc')->get();
        $actualPlan = $groupCompany->plan;
        $date = $this->getDate($transactions);
        $transactionPending = null;

        if ($this->hasBankSlip($transactions)) {
            $transactionPending = $transactions->first();
        }

        if ($transactions->count() > 0 && $transactions->first()->status == self::CANCELED_SIGNATURE) {
            $date = null;
            $actualPlan = null;
        }

        return view('signatures.index', compact('actualPlan', 'date', 'transactions', 'transactionPending'));
    }

    public function cancellation()
    {
        $groupCompany = \Auth::user()->groupCompany;
        $this->createCancellationTransaction($groupCompany);
        $groupCompany->update(['plan_status' => false]);

        return redirect()
            ->route('signatures.index')
            ->with(['success' => 'Assinatura cancelada com sucesso']);
    }

    public function indexSelectPlan()
    {
        $plans = $this->planRepository->all();
        $actualPlan = \Auth::user()->groupCompany->plan;
        $modules = app(\Delos\Dgp\Repositories\Contracts\ModuleRepository::class)->orderBy('name', 'asc')->all();
        return view('signatures.indexSelectPlan', compact('plans', 'actualPlan', 'modules'));
    }

    public function storePlan(int $planId)
    {
        $plan = $this->planRepository->find($planId);
        session(['plan_selected' => $plan->id]);
        return redirect()->route('checkout.index');
    }

    private function getDate($transactions)
    {
        $date = $transactions->last()->billing_date ?? null;

        if (isset($date) && ($transactions->last()->status == self::PAID_OUT || $transactions->last()->status == self::BEGINNING_TEST_PERIOD)) {
            $date = $transactions->last()->billing_date->addMonth();
        }
        return $date;
    }

    private function createCancellationTransaction($groupCompany): void
    {
        $this->paymentTransaction->create([
            'billing_date' => Carbon::now(),
            'status' => self::CANCELED_SIGNATURE,
            'value_paid' => '0',
            'group_company_id' => $groupCompany->id
        ]);
    }

    private function hasBankSlip($transactions): bool
    {
        return $transactions->count() > 0 && $transactions->first()->status == self::AWAITING_PAYMENT;
    }
}