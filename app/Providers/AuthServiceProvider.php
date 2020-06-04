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


            Gate::define('generate-key-user', function() {
                return true;
            });

            Gate::define('index-supplier-expense', function() {
                return true;
            });

            Gate::define('create-supplier-expense', function() {
                return true;
            });


            Gate::define('edit-supplier-expense', function() {
                return true;
            });

            Gate::define('update-supplier-expense', function() {
                return true;
            });

            Gate::define('destroy-supplier-expense', function() {
                return true;
            });

            Gate::define('update-allocation', function() {
                return true;
            });

            Gate::define('edita-allocation', function() {
                return true;
            });


            Gate::define('index-app-version',function(){
                return true;
            });

            Gate::define('store-app-version',function(){
                return true;
            });

            Gate::define('create-app-version',function(){
                return true;
            });

            Gate::define('index-supplier-expenses-import', function () {
                return true;
            });

            Gate::define('store-supplier-expenses-import', function () {
                return true;
            });

            Gate::define('update-supplier-expenses-import', function () {
                return true;
            });

            Gate::define('create-supplier-expenses-import', function () {
                return true;
            });

            Gate::define('payment-write-offs-expense',function(){
                return true;
            });

            Gate::define('payment-write-offs-supplier-expense',function(){
                return true;
            });

            Gate::define('apportionments-expense',function(){
                return true;
            });

            Gate::define('apportionments-supplier-expense',function(){
                return true;
            });
            
            Gate::define('index-payment',function(){
                return true;
            });

            Gate::define('create-payment',function(){
                return true;
            });

            
            Gate::define('update-payment',function(){
                return true;
            });

            Gate::define('destroy-payment', function(){
                return true;
            });

            Gate::define('index-payment-type-provider',function(){
                return true;
            });

            Gate::define('create-payment-type-provider',function(){
                return true;
            });

            
            Gate::define('update-payment-type-provider',function(){
                return true;
            });

            Gate::define('destroy-payment-type-provider',function(){
                return true;
            });
           
            Passport::routes();
        } catch(\Exception $e) {

        }
    }
}
