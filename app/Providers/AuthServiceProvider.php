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
            $val = '';
            DB::table('permissions')
                ->get(['id', 'slug'])
                ->each(function($permission) {
                   $val= ($permission->slug == "index-import")?$permission->slug:'';
                    Gate::define($permission->slug, function ($user) use ($permission) {
                        return $user->role
                            ->permissions
                            ->contains($permission->id);
                    });

                    Gate::define('index-import', function ($user) use ($permission) {
                       return true;
                    });

                    Gate::define('upload-import', function ($user) use ($permission) {
                        return true;
                     });

                    Gate::define('index-revenues', function ($user) use ($permission) {
                        return true;
                     });

                    Gate::define('index-contracts',function($user) use ($permission){
                        return true;
                    });

                    Gate::define('create-contract',function($user) use ($permission){
                        return true;
                    });

                    Gate::define('update-contract',function($user) use ($permission){
                        return true;
                    });


                    Gate::define('delete-contract', function($user) {
                        return true;
                    });

            });

            Passport::routes();
        } catch(\Exception $e) {

        }
    }
}
