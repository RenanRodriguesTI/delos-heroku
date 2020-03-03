<?php

namespace Delos\Dgp\Http\Controllers;

use Carbon\Carbon;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\PaymentInformation;
use Delos\Dgp\Entities\PaymentTransaction;
use Delos\Dgp\Events\BillingToDo;
use Delos\Dgp\Listeners\SendEmailForGenerateBankSlip;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Delos\Dgp\Repositories\Contracts\PlanRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * @var PaymentInformation
     */
    private $paymentInformation;
    /**
     * @var PaymentTransaction
     */
    private $paymentTransaction;
    /**
     * @var GroupCompany
     */
    private $groupCompany;
    /**
     * @var PlanRepository
     */
    private $planRepository;

    public function __construct(PaymentInformation $paymentInformation, PlanRepository $planRepository, PaymentTransaction $paymentTransaction, GroupCompanyRepository $groupCompany)
    {
        $this->paymentInformation = $paymentInformation;
        $this->planRepository = $planRepository;
        $this->paymentTransaction = $paymentTransaction;
        $this->groupCompany = $groupCompany;
    }

    /**
     * Getting variables to checkout view and display
     * @return Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paymentInformation = $this->getPaymentInformation();
        $plan = $this->planRepository->find(session('plan_selected'));
        $dueDateToBankSlip = app(SendEmailForGenerateBankSlip::class)->getDueDateToBankSlip(Carbon::now())->format('d/m/Y');
        $groupCompany = \Auth::user()->groupCompany;
        $price = $plan->value;

        return view('checkout.index', compact('paymentInformation', 'plan', 'dueDateToBankSlip', 'groupCompany', 'price'));    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_bank_slip'] = $data['payment_type'] == 'bank-slip' ? true : false;

        $this->validateOrRedirect($data);

        $paymentInformation = $this->paymentInformationUpdate($data);
        $this->updatePlanInGroupCompany($paymentInformation);
        $paymentTransaction = $this->createPaymentTransaction($paymentInformation);

        event(new BillingToDo($paymentInformation, $paymentTransaction));

        return redirect()
            ->route('signatures.index')
            ->with('success', 'Plano assinado com sucesso. Em breve mandaremos o boleto para você');
    }

    private function getPaymentInformation()
    {
        $paymentInformation = $this->paymentInformation->whereHas('groupCompany', function (Builder $query) {
            $query->where('id', \Auth::user()->groupCompany->id);
        })->first();
        return $paymentInformation;
    }

    private function validateOrRedirect($data): void
    {
        Validator::make($data, [
            'name' => 'required|string|min:3',
            'email' => 'required|email|string|min:5',
            'telephone' => 'required|string|min:14|max:15',
            'document.type' => 'required|string|in:CPF,CNPJ',
            'document.number' => 'required|string|min:14|max:18',
            'address.postal_code' => 'required|string|size:9',
            'address.street' => 'required|string',
            'address.district' => 'required|string',
            'address.city' => 'required|string',
            'address.state' => 'required|string',
            'is_bank_slip' => 'required|boolean'
        ])->validate();
    }

    private function paymentInformationUpdate($data)
    {
        $paymentInformation = $this->getPaymentInformation();

        if (!$paymentInformation) {
            $paymentInformation = $this->paymentInformation->create(['group_company_id' => \Auth::user()->groupCompany->id]);
        }

        $paymentInformation->update($data);
        return $paymentInformation->fresh();
    }

    private function createPaymentTransaction(PaymentInformation $paymentInformation): PaymentTransaction
    {
        $paymentTransaction = $this->paymentTransaction->create([
            'billing_date' => Carbon::now(),
            'status' => SignaturesController::GENERATING_BANK_SLIP,
            'group_company_id' => $paymentInformation->groupCompany->id,
        ]);
        return $paymentTransaction;
    }

    private function updatePlanInGroupCompany($paymentInformation): void
    {
        $this->groupCompany
            ->update([
                'plan_id' => session('plan_selected'),
                'billing_date' => Carbon::now(),
                'plan_status' => true],
            $paymentInformation->groupCompany->id);
    }

    private function getHolidays()
    {
        $holidays = app(HolidayRepository::class)->pluck('date')->map(function ($item) {
            return $item->format('Y-m-d');
        });
        return $holidays;
    }
}
