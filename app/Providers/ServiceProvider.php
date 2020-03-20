<?php

namespace Delos\Dgp\Providers;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use Delos\Dgp\Services\ServiceInterface;

class ServiceProvider extends SupportServiceProvider
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
        $this->app->when(\Delos\Dgp\Http\Controllers\ClientsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ClientService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\GroupsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\GroupService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\RolesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\RoleService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\UsersController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\UserService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\FinancialRatingsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\FinancialRatingService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\ProjectsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ProjectService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\CarTypesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\CarTypeService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\PlacesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\PlaceService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\TasksController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\TaskService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\ActivitiesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ActivityService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\AuditsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\AuditService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\PermissionsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\PermissionService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\ProjectTypesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ProjectTypeService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\RequestsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\RequestService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\TransportationFacilitiesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\TransportationFacilityService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\StatesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\StateService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\AirportsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\AirportService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\MissingActivitiesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\MissingActivityService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\CitiesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\CityService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\ExpenseTypesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ExpenseTypeService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\ExpensesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ExpenseService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\DebitMemosController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\DebitMemoService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\HolidaysController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\HolidayService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\CompaniesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\CompanyService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\GroupCompaniesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\GroupCompanyService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\PlansController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\PlanService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\ModulesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ModuleService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\AllocationsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\AllocationService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\CoastUsersController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\CoastUserService::class);

        $this->app->when(\Delos\Dgp\Http\Controllers\ImportsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ProjectService::class);
        
        $this->app->when(\Delos\Dgp\Http\Controllers\RevenuesController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ProjectService::class);
                  
        $this->app->when(\Delos\Dgp\Http\Controllers\ContractsController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ContractsService::class);
        
        $this->app->when(\Delos\Dgp\Http\Controllers\ProvidersController::class)
                  ->needs(ServiceInterface::class)
                  ->give(\Delos\Dgp\Services\ProviderService::class);

                  
        $this->app->when(\Delos\Dgp\Http\Controllers\Api\ExpensesApiController::class)
        ->needs(ServiceInterface::class)
        ->give(\Delos\Dgp\Services\ExpenseService::class);
    }
}
