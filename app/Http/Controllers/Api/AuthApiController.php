<?php

namespace Delos\Dgp\Http\Controllers\Api;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\Company;
use Delos\Dgp\Entities\FinancialRating;
use Delos\Dgp\Entities\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Http\Controllers\SignaturesController;

class AuthapiController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param [string] Companny
     * @return [string] message
     */

    private const DEFAULT_PLAN_ID = 3;
    private const DEFAULT_ROLE_ID = 4;

    public function signup(Request $request)
    {
        $request->validate([
            'company' =>"required|string",
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        // $user = new User([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password)
        // ]);
        // $user->save();

        $groupName = 'Grupo '. $request['company'];

        $group = GroupCompany::create([
            'name' => $groupName,
            'plan_id' => self::DEFAULT_PLAN_ID,
            'signature_date' => Carbon::now(),
            'is_defaulting' => false,
            'plan_status' => true
        ]);

        $company = Company::create([
            'name' => $request['company'],
            'group_company_id' => $group['id']
        ]);

        $this->AddFinancialRating($group);
        session(['groupCompanies'=>[$group["id"]]]);
        session(['companies'=>[$company["id"]]]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'role_id' => self::DEFAULT_ROLE_ID, // administrator
            'group_company_id' => $group['id'],
            'company_id' => $company['id'],
            'password' => bcrypt($request['password']),
        ]);

        PaymentTransaction::create([
            'billing_date' => Carbon::now(),
            'payday' => Carbon::now(),
            'status' => SignaturesController::BEGINNING_TEST_PERIOD,
            'group_company_id' => $group->id,
        ]);



        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Access Token User ');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user'=>$user
        ]);
    }


  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        Auth::guard('api')->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json(Auth::guard('api')->user());
    }

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
