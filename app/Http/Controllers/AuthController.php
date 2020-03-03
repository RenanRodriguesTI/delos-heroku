<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Http\Requests;
use Delos\Dgp\Policies\UserPolicy;
use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator as Url;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {        
        $this->authManager = $authManager;
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function attempt(Request $request, Url $url)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255'
        ]);

        $credentials = $request->only(['email', 'password']);
        $remember = $request->has('remember');

        if($this->authManager->attempt($credentials, $remember)) {
            $nextUri = strstr($url->previous(), 'next-uri=');
            $nextUri = str_replace('next-uri=', '', $nextUri);

            session(['groupCompanies' => [\Auth::user()->group_company_id]]);

            if ( Auth::user()->role_id == 5 ) {
                session(['groupCompanies' => app(GroupCompanyRepository::class)->pluck('id')->toArray()]);
            }

            session(['companies' => Auth::user()->groupCompany->companies()->pluck('id')->toArray()]);

            if($nextUri !== '') {
                return redirect()->to($nextUri);
            }

            return redirect('/');
        }

        return redirect()
            ->back()
            ->with('fail', trans('auth.failed'))
            ->withInput();

    }

    public function logout(Request $request)
    {
        $this->authManager->logout();
        $request->session()->flush();
        return redirect()->route('auth.login');
    }
}
