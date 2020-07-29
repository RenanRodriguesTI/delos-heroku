<?php

namespace Delos\Dgp\Providers;

use Delos\Dgp\Entities\Activity;
use Delos\Dgp\Entities\Expense;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\Request;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Observers\ActivityObserver;
use Delos\Dgp\Observers\ExpenseObserver;
use Delos\Dgp\Observers\ProjectObserver;
use Delos\Dgp\Observers\RequestObserver;
use Delos\Dgp\Observers\UserObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->changeRouteAndUrlHelpersToHttps();
        $this->callCustomValidators();
        $this->callObservers();
        $this->callCustomBladeDirective();

        if (env('APP_ENV') && env('APP_ENV') == 'local') {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    private function changeRouteAndUrlHelpersToHttps(): void
    {
        if (env('APP_ENV') !== 'local') {
            \URL::forceScheme('https');
        }
    }

    private function callCustomValidators(): void
    {
        Validator::extend('not_more', 'Delos\Dgp\Validators\Custom\NotQuantityTotalHoursPerTask');

        Validator::replacer('after_or_equal', function ($message, $attribute, $rule, $parameters) {

            return str_replace(':date', $parameters[0], $message);
        });

        Validator::extend('value', 'StartPeriodRule@validate');
        Validator::extend('value', 'NumberFormatRule@validate');
        Validator::extend('value', 'MinValueRule@validate');
        Validator::extend('value', 'CNPJRule@validate');
        Validator::extend('value', 'CPFRule@validate');
        Validator::extend('value','TelephoneRule@validate');
        Validator::extend('value','StringDefaultSizeRule@validate');
        Validator::extend('value','ValidateOfficePeriodRule@validate');
    }

    private function callObservers(): void
    {
        User::observe(UserObserver::class);
        Activity::observe(ActivityObserver::class);
        Project::observe(ProjectObserver::class);
        Request::observe(RequestObserver::class);
        Expense::observe(ExpenseObserver::class);
    }

    private function callCustomBladeDirective()
    {
        Blade::directive('can', function ($expression) {
            return "<?php if (app('Illuminate\\Contracts\\Auth\\Access\\Gate')->check({$expression}) && app('Delos\\Dgp\\Http\\Middleware\\ModulesPermissions')->groupAuthorize({$expression})): ?>";
        });
    }
}
