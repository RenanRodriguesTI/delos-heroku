<?php

namespace Delos\Dgp\Providers;

use Delos\Dgp\Repositories\Contracts;
use Delos\Dgp\Repositories\Eloquent;
use Illuminate\Support\ServiceProvider as SP;

class RepositoryServiceProvider extends SP
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Contracts\ActivityRepository::class, Eloquent\ActivityRepositoryEloquent::class);
        $this->app->bind(Contracts\AirportRepository::class, Eloquent\AirportRepositoryEloquent::class);
        $this->app->bind(Contracts\AuditRepository::class, Eloquent\AuditRepositoryEloquent::class);
        $this->app->bind(Contracts\CarTypeRepository::class, Eloquent\CarTypeRepositoryEloquent::class);
        $this->app->bind(Contracts\CityRepository::class, Eloquent\CityRepositoryEloquent::class);
        $this->app->bind(Contracts\ClientRepository::class, Eloquent\ClientRepositoryEloquent::class);
        $this->app->bind(Contracts\FinancialRatingRepository::class, Eloquent\FinancialRatingRepositoryEloquent::class);
        $this->app->bind(Contracts\GroupRepository::class, Eloquent\GroupRepositoryEloquent::class);
        $this->app->bind(Contracts\MissingActivityRepository::class, Eloquent\MissingActivityRepositoryEloquent::class);
        $this->app->bind(Contracts\PermissionRepository::class, Eloquent\PermissionRepositoryEloquent::class);
        $this->app->bind(Contracts\PlaceRepository::class, Eloquent\PlaceRepositoryEloquent::class);
        $this->app->bind(Contracts\ProjectRepository::class, Eloquent\ProjectRepositoryEloquent::class);
        $this->app->bind(Contracts\ProjectTypeRepository::class, Eloquent\ProjectTypeRepositoryEloquent::class);
        $this->app->bind(Contracts\RequestRepository::class, Eloquent\RequestRepositoryEloquent::class);
        $this->app->bind(Contracts\RoleRepository::class, Eloquent\RoleRepositoryEloquent::class);
        $this->app->bind(Contracts\StateRepository::class, Eloquent\StateRepositoryEloquent::class);
        $this->app->bind(Contracts\TaskRepository::class, Eloquent\TaskRepositoryEloquent::class);
        $this->app->bind(Contracts\TransportationFacilityRepository::class, Eloquent\TransportationFacilityRepositoryEloquent::class);
        $this->app->bind(Contracts\UserRepository::class, Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(Contracts\CompanyRepository::class, Eloquent\CompanyRepositoryEloquent::class);
        $this->app->bind(Contracts\ExpenseTypeRepository::class, Eloquent\ExpenseTypeRepositoryEloquent::class);
        $this->app->bind(Contracts\ExpenseRepository::class, Eloquent\ExpenseRepositoryEloquent::class);
        $this->app->bind(Contracts\PaymentTypeRepository::class, Eloquent\PaymentTypeRepositoryEloquent::class);
        $this->app->bind(Contracts\DebitMemoRepository::class, Eloquent\DebitMemoRepositoryEloquent::class);
        $this->app->bind(Contracts\HolidayRepository::class, Eloquent\HolidayRepositoryEloquent::class);
        $this->app->bind(Contracts\CompanyRepository::class, Eloquent\CompanyRepositoryEloquent::class);
        $this->app->bind(Contracts\GroupCompanyRepository::class, Eloquent\GroupCompanyRepositoryEloquent::class);
        $this->app->bind(Contracts\PlanRepository::class, Eloquent\PlanRepositoryEloquent::class);
        $this->app->bind(Contracts\ModuleRepository::class, Eloquent\ModuleRepositoryEloquent::class);
        $this->app->bind(Contracts\AllocationRepository::class, Eloquent\AllocationRepositoryEloquent::class);
        $this->app->bind(Contracts\CoastUserRepository::class, Eloquent\CoastUserRepositoryEloquent::class);

        $this->app->bind(Contracts\ActivityApiRepository::class, Eloquent\ActivityApiRepositoryEloquent::class);
        $this->app->bind(Contracts\HolidayApiRepository::class, Eloquent\HolidayApiRepositoryEloquent::class);
        $this->app->bind(Contracts\SupplierExpensesRepository::class, Eloquent\SupplierExpensesRepositoryEloquent::class);
        $this->app->bind(Contracts\AppVersionRepository::class, Eloquent\AppVersionRepositoryEloquent::class);
        $this->app->bind(Contracts\AppVersionApiRepository::class, Eloquent\AppVersionApiRepositoryEloquent::class);
        $this->app->bind(Contracts\PaymentTypeProviderRepository::class,Eloquent\PaymentTypeProviderRepositoryEloquent::class);
        $this->app->bind(Contracts\OfficeRepository::class,Eloquent\OfficeRepositoryEloquent::class);
        $this->app->bind(Contracts\ApprovedNotificationRepository::class,Eloquent\ApprovedNotificationRepositoryEloquent::class);
        $this->app->bind(Contracts\TypeNotifyRepository::class,Eloquent\TypeNotifyRepository::class);
        $this->app->bind(Contracts\EpiRepository::class,Eloquent\EpiRepositoryEloquent::class);
        $this->app->bind(Contracts\CurseRepository::class,Eloquent\CurseRepositoryEloquent::class);
        $this->app->bind(Contracts\EpiUserRepository::class,Eloquent\EpiUserRepositoryEloquent::class);
    }
}
