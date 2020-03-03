<?php

namespace Delos\Dgp\Http\Controllers\Auth;
use Delos\Dgp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Translation\Translator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $subject;

    public function __construct(Translator $translator)
    {
        $this->middleware('guest');
        $this->subject = $translator->trans('subjects.reset-link');
    }
}