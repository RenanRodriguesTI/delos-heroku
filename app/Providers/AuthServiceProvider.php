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

            // Gate::define('manager-allocation',function(){
            //     return true;
            // });

            // Gate::define('list-by-project-allocation',function(){
            //     return true;
            // });

            // Gate::define('manager-approved-hours-allocation',function(){
            //     return true;
            // });

            // Gate::define('get-by-project-activity',function(){
            //     return true;
            // });

            // Gate::define('destroy-activity', function(){
            //     return true;
            // });

            // Gate::define('approve-activity', function(){
            //     return true;
            // });


            // Gate::define('manager-expense-allocation',function(){
            //     return true;
            // });

            // Gate::define('manager-approve-expense',function(){
            //     return true;
            // });

            // Gate::define('manager-reprove-expense',function(){
            //     return true;
            // });


            // Gate::define('index-approved-notification',function(){
            //     return true;
            // });

            // Gate::define('users-by-project-allocation',function(){
            //     return true;
            // });

            // Gate::define('reprove-activity',function(){
            //     return true;
            // });

            // Gate::define('add-tasks-index-allocation',function(){
            //     return true;
            // });

            // Gate::define('add-task-store-allocation',function(){
            //     return true;
            // });

            Gate::define('check-hours-task-allocation',function(){
                return true;
            });

            // Gate::define('index-document',function(){
            //     return true;
            // });

            Gate::define('list-document',function(){
                return true;
            });

            Gate::define('store-epi',function(){
                return true;
            });

            Gate::define('create-epi',function(){
                return true;
            });

            // Gate::define('index-epi',function(){
            //     return true;
            // });

            Gate::define('update-epi',function(){
                return true;
            });

            Gate::define('destroy-epi',function(){
                return true;
            });

            Gate::define('withdraw-epi',function(){
                return true;
            });

            Gate::define('update-epi-user',function(){
                return true;
            });

            Gate::define('store-curse',function(){
                return true;
            });

            Gate::define('create-curse',function(){
                return true;
            });

            Gate::define('update-curse',function(){
                return true;
            });

            Gate::define('destroy-curse',function(){
                return true;
            });

            Gate::define('index-resource',function(){
                return true;
            });

            Gate::define('show-resource',function(){
                return true;
            });


            Passport::routes();
        } catch(\Exception $e) {

        }
    }
}
