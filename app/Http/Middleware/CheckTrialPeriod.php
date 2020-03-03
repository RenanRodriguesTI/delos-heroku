<?php

namespace Delos\Dgp\Http\Middleware;

use Closure;

class CheckTrialPeriod
{
    private $groupCompany;
    private $user;

    public function __construct()
    {
        $this->groupCompany = \Auth::user()->groupCompany;
        $this->user = \Auth::user();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->groupCompany->is_defaulting) {
            session(['trial_period_expired' => true]);

            if (url()->route('selectPlan') !== url()->current() && $this->user->can('index-select-plan-signature')) {
                session(['plan_selected' => $this->groupCompany->plan->id]);
                return redirect()->route('checkout.index');
            }

            if (route('home.index') !== url()->current() && !$this->user->can('index-select-plan-signature')) {
                return redirect()->route('home.index');
            }
        }

        $this->groupCompany->is_defaulting ? session(['trial_period_expired' => true]) : session(['trial_period_expired' => false]);
        return $next($request);
    }
}
