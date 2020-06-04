<?php

namespace Delos\Dgp\Http;

use Delos\Dgp\Http\Middleware\IsDownloadMiddleware;
use Delos\Dgp\Http\Middleware\ModulesPermissions;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Delos\Dgp\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Delos\Dgp\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Delos\Dgp\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            // \Laravel\Passport\Http\Middleware\CheckClientCredentials::class
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Delos\Dgp\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Delos\Dgp\Http\Middleware\Authorize::class,
        'guest' => \Delos\Dgp\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'force-ssl' => \Delos\Dgp\Http\Middleware\ForceSSL::class,
        'project-has-created' => \Delos\Dgp\Http\Middleware\VerifyProjectCreated::class,
        'is-download' => IsDownloadMiddleware::class,
        'module-permissions' => ModulesPermissions::class,
        'check-trial-period' => \Delos\Dgp\Http\Middleware\CheckTrialPeriod::class,
        'has-bank-slip' => \Delos\Dgp\Http\Middleware\HasBankSlip::class
    ];
}
