<?php

namespace Delos\Dgp\Providers;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [        
        \Delos\Dgp\Entities\Project::class => \Delos\Dgp\Policies\ProjectPolicy::class,
        \Delos\Dgp\Entities\User::class => \Delos\Dgp\Policies\UserPolicy::class,
        \Delos\Dgp\Entities\Activity::class => \Delos\Dgp\Policies\ActivityPolicy::class,
        \Delos\Dgp\Entities\Expense::class => \Delos\Dgp\Policies\ExpensePolicy::class,
        \Delos\Dgp\Entities\Request::class => \Delos\Dgp\Policies\RequestPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        try {
            DB::table('permissions')
                ->get(['id', 'slug'])
                ->each(function($permission) {
                    Gate::define($permission->slug, function ($user) use ($permission) {
                        return $user->role
                            ->permissions
                            ->contains($permission->id);
                    });
            });

            Passport::routes();
        } catch(\Exception $e) {

        }
    }
}
