<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 07/11/17
 * Time: 10:26
 */

namespace Delos\Dgp\Http\Middleware;

use Closure;
use Delos\Dgp\Http\Controllers\SignaturesController;

class HasBankSlip
{
    public function handle($request, Closure $next)
    {
        $groupCompany = \Auth::user()->groupCompany;
        $transactions = $groupCompany->paymentTransactions()->orderBy('id', 'desc')->get();

        session(['has_bank_slip' => false]);

        if ($this->hasBankSlip($transactions)) {
            session(['has_bank_slip' => true]);
        }

        return $next($request);
    }

    private function hasBankSlip($transactions): bool
    {
        return $transactions->count() > 0 && $transactions->first()->status == SignaturesController::AWAITING_PAYMENT;
    }
}