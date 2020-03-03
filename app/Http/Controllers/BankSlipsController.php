<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 07/11/17
 * Time: 10:56
 */

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Entities\PaymentTransaction;
use Delos\Dgp\Events\BankSlipApproved;
use Delos\Dgp\Events\BankSlipGenerated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BankSlipsController extends Controller
{
    private $paymentTransaction;
    private $storage;

    public function __construct(PaymentTransaction $paymentTransaction, Storage $storage)
    {
        $this->paymentTransaction = $paymentTransaction;
        $this->storage = $storage;
    }

    public function index()
    {
        $transactionsToDo = $this->getTransactionsToDo();
        $transactionsPendingAproval = $this->getTransactionsPendingApproval();
        Session::flash('bank_slip_upload', false);
        return view('bank-slips.index', compact('transactionsToDo', 'transactionsPendingAproval'));
    }

    public function edit(int $id)
    {
        $transactionsToDo = $this->getTransactionsToDo();
        $transactionsPendingAproval = $this->getTransactionsPendingApproval();
        $actualTransaction = $this->paymentTransaction->find($id);
        Session::flash('bank_slip_upload', true);
        return view('bank-slips.index', compact('transactionsToDo', 'actualTransaction', 'transactionsPendingAproval'));
    }

    public function approve(int $id)
    {
        $transaction = $this->paymentTransaction->find($id);
        $transaction->update(['status' => SignaturesController::PAID_OUT, 'payday' => Carbon::now()]);
        $transaction->groupCompany()->update([
            'is_defaulting' => false,
            'status_plan' => true
        ]);
        event(new BankSlipApproved($transaction));

        return redirect()
            ->route('bankSlips.index')
            ->with(['success' => 'Boleto recebido com sucesso']);
    }

    /**
     * Validate and add bank slip and value to \Delos\Entities\PaymentTransaction
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $this->validateOrRedirect($request->all());

        $paymentTransaction = $this->paymentTransaction->find($id);
        $paymentTransaction->update([
            'value_paid' => $request->all()['value_paid']
        ]);

        $this->uploadBankSlipToS3($request, $paymentTransaction);

        event(new BankSlipGenerated($paymentTransaction));

        return redirect()
            ->route('bankSlips.index')
            ->with(['success' => 'Boleto adicionado com sucesso']);
    }

    /**
     * Validate or fail and redirect
     * @param $data
     */
    private function validateOrRedirect($data): void
    {
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
        $data['value_paid'] = $numberFormatter->parse($data['value_paid']);

        Validator::make($data, [
            'value_paid' => 'required|regex:/^[0-9]+[.]?[0-9]{2}/',
            'bank_slip' => 'required|file|mimetypes:application/pdf'
        ])->validate();
    }

    public function destroy(int $id)
    {
        $paymentTransaction = $this->paymentTransaction->find($id);
        $paymentTransaction->update(['status' => SignaturesController::TRANSFER_CANCELED]);

        return redirect()
            ->route('bankSlips.index')
            ->with(['success' => 'Boleto cancelado com sucesso']);
    }

    private function getTransactionsToDo()
    {
        $transactions = $this->paymentTransaction->where('status', SignaturesController::GENERATING_BANK_SLIP)->get();
        return $transactions;
    }

    private function getTransactionsPendingApproval()
    {
        $transactions = $this->paymentTransaction->where('status', SignaturesController::AWAITING_PAYMENT)->get();
        return $transactions;
    }

    private function getFullPath($paymentTransaction): string
    {
        return 'Pdfs/' . $paymentTransaction->groupCompany->id . '/' . Carbon::now()->month . '/' . $paymentTransaction->id . '.pdf';
    }

    /**
     * Upload bank slip to amazon s3
     * @param Request $request
     * @param $paymentTransaction
     */
    private function uploadBankSlipToS3(Request $request, $paymentTransaction): void
    {
        $bankSlip = $request->file('bank_slip');
        $this->storage->put($this->getFullPath($paymentTransaction), file_get_contents($bankSlip), 'public');
        $paymentTransaction->update(['status' => SignaturesController::AWAITING_PAYMENT]);
    }
}