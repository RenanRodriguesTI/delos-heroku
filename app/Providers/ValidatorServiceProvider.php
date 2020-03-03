<?php

namespace Delos\Dgp\Providers;

use Illuminate\Support\ServiceProvider;
use Prettus\Validator\Contracts\ValidatorInterface;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->when(\Delos\Dgp\Services\ActivityService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\ActivityValidator::class);

        $this->app->when(\Delos\Dgp\Services\AirportService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\AirportValidator::class);

        $this->app->when(\Delos\Dgp\Services\AuditService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\AuditValidator::class);

        $this->app->when(\Delos\Dgp\Services\CarTypeService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\CarTypeValidator::class);

        $this->app->when(\Delos\Dgp\Services\CityService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\CityValidator::class);

        $this->app->when(\Delos\Dgp\Services\ClientService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\ClientValidator::class);

        $this->app->when(\Delos\Dgp\Services\DebitMemoService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\DebitMemoValidator::class);

        $this->app->when(\Delos\Dgp\Services\ExpenseService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\ExpenseValidator::class);

        $this->app->when(\Delos\Dgp\Services\ExpenseTypeService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\ExpenseTypeValidator::class);

        $this->app->when(\Delos\Dgp\Services\FinancialRatingService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\FinancialRatingValidator::class);

        $this->app->when(\Delos\Dgp\Services\GroupService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\GroupValidator::class);

        $this->app->when(\Delos\Dgp\Services\HolidayService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\HolidayValidator::class);

        $this->app->when(\Delos\Dgp\Services\MissingActivityService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\MissingActivityValidator::class);

        $this->app->when(\Delos\Dgp\Services\PermissionService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\PermissionValidator::class);

        $this->app->when(\Delos\Dgp\Services\PlaceService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\PlaceValidator::class);

        $this->app->when(\Delos\Dgp\Services\ProjectService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\ProjectValidator::class);

        $this->app->when(\Delos\Dgp\Services\ProjectTypeService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\ProjectTypeValidator::class);

        $this->app->when(\Delos\Dgp\Services\RequestService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\RequestValidator::class);

        $this->app->when(\Delos\Dgp\Services\RoleService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\RoleValidator::class);

        $this->app->when(\Delos\Dgp\Services\StateService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\StateValidator::class);

        $this->app->when(\Delos\Dgp\Services\TaskService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\TaskValidator::class);

        $this->app->when(\Delos\Dgp\Services\TransportationFacilityService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\TransportationFacilityValidator::class);

        $this->app->when(\Delos\Dgp\Services\UserService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\UserValidator::class);

        $this->app->when(\Delos\Dgp\Services\CompanyService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\CompanyValidator::class);

        $this->app->when(\Delos\Dgp\Services\GroupCompanyService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\GroupCompanyValidator::class);

        $this->app->when(\Delos\Dgp\Services\PlanService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\PlanValidator::class);

        $this->app->when(\Delos\Dgp\Services\ModuleService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\ModuleValidator::class);

        $this->app->when(\Delos\Dgp\Services\AllocationService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\AllocationValidator::class);

        $this->app->when(\Delos\Dgp\Services\CoastUserService::class)
                  ->needs(ValidatorInterface::class)
                  ->give(\Delos\Dgp\Validators\CoastUserValidator::class);

    }
}
