<?php

namespace Delos\Dgp\Http\Controllers\Auth;

use Carbon\Carbon;
use Delos\Dgp\Entities\FinancialRating;
use Delos\Dgp\Entities\PaymentTransaction;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Http\Controllers\SignaturesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\Company;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'auth/login';

    private const DEFAULT_PLAN_ID = 3;
    private const DEFAULT_ROLE_ID = 4;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    public function index()
    {
        return view('auth.register');
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $groupName = 'Grupo ' . $data['company'];

        $group = GroupCompany::create([
            'name' => $groupName,
            'plan_id' => self::DEFAULT_PLAN_ID,
            'signature_date' => Carbon::now(),
            'is_defaulting' => false,
            'plan_status' => true
        ]);

        $company = Company::create([
            'name' => $data['company'],
            'group_company_id' => $group['id']
        ]);

        $this->AddFinancialRating($group);

        session(['groupCompanies' => [$group['id']]]);
        session(['companies' => [$company['id']]]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => self::DEFAULT_ROLE_ID, // administrator
            'group_company_id' => $group['id'],
            'company_id' => $company['id'],
            'password' => bcrypt($data['password']),
        ]);

        PaymentTransaction::create([
            'billing_date' => Carbon::now(),
            'payday' => Carbon::now(),
            'status' => SignaturesController::BEGINNING_TEST_PERIOD,
            'group_company_id' => $group->id,
        ]);

        return $user;
    }

    /**
     * Create FinancialRating for group
     * @param $group
     */
    private function AddFinancialRating($group): void
    {
        FinancialRating::create([
            'cod' => '03',
            'description' => 'Despesas por conta do cliente',
            'group_company_id' => $group->id
        ]);

        FinancialRating::create([
            'cod' => '02',
            'description' => 'Despesas por conta da empresa',
            'group_company_id' => $group->id
        ]);
    }
}