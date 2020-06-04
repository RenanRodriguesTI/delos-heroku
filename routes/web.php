<?php
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */


    Route::group(['middleware' => ['force-ssl']], function () {

        Route::group(['prefix' => 'password', 'namespace' => 'Auth'], function () {
            Route::get('reset', ['as' => 'password.reset', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
            Route::post('email', ['as' => 'password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
            Route::get('reset/{token}', ['as' => 'password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
            Route::post('reset', ['as' => 'password.reset', 'uses' => 'ResetPasswordController@reset']);

        });

        Route::group(['prefix' => 'auth'], function () {
            Route::get('login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
            Route::post('attempt', ['as' => 'auth.attempt', 'uses' => 'AuthController@attempt']);
            Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@index']);
            Route::post('register', 'Auth\RegisterController@register');
            Route::get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
        });
        Route::pattern('id', '[0-9]+');

        Route::group(['middleware' => ['auth']], function () {
            Route::get('/reports/different-end-dates-in-projects', ['as' => 'reports.differentEndDatesInProjects', 'uses' => 'ProjectEndDatesReportController@index']);
        });


        Route::group(['middleware' => ['auth', 'can', 'module-permissions', 'has-bank-slip']], function () {

            Route::group(['middleware' => 'check-trial-period'], function () {

                Route::get('', ['as' => 'home.index', 'uses' => 'HomeController@index']);

                Route::group(['prefix' => 'allocations', 'as' => 'allocations.'], function () {

                    Route::get('/', ['as' => 'index', 'uses' => 'AllocationsController@index']);
                    Route::get('/report', ['as' => 'report', 'uses' => 'AllocationsController@report']);
                    Route::get('/gcalendar', ['as' => 'gcalendar', 'uses' => 'AllocationsController@gcalendar']);
                    Route::get('/google/callback', ['as' => 'gcalendar.callback', 'uses' => 'AllocationsController@gcalendarCallback']);
                    Route::get('/create', ['as' => 'create', 'uses' => 'AllocationsController@create']);

                    Route::get('/check-period-hours', ['as' => 'checkPeriodHours', 'uses' => 'AllocationsController@checkPeriodHours']);

                    Route::get('{id}/show', ['as' => 'show', 'uses' => 'AllocationsController@show']);
                    Route::post('/create', ['as' => 'store', 'uses' => 'AllocationsController@store']);
                    Route::post('/{id}/destroy', ['as' => 'destroy', 'uses' => 'AllocationsController@destroy']);
                    Route::post('/{id}/update-hours', ['as' => 'updateHours', 'uses' => 'AllocationsController@updateHours']);
                    Route::post('/{id}/update-tasks', ['as' => 'updateTasks', 'uses' => 'AllocationsController@updateTasks']);
                    Route::post('/{id}/update-status', ['as' => 'updateStatus', 'uses' => 'AllocationsController@updateStatus']);
                    Route::get('/{id}/edit',['as'=>'edit', 'uses' => 'AllocationsController@edit']);
                    Route::post('/{id}/edit',['as'=>'update','uses' => 'AllocationsController@update']);

                    Route::get('/calc-hours',['as'=>'calcHoursPeriod','uses' =>'AllocationsController@calcHoursPeriod']);
                    Route::post('/{id}/check-hours',['as'=>'checkHours','uses' => 'AllocationsController@checkHours']);
                });

                Route::group(['prefix' => 'clients'], function () {
                    Route::get('', ['as' => 'clients.index', 'uses' => 'ClientsController@index']);
                    Route::get('{id}/edit', ['as' => 'clients.edit', 'uses' => 'ClientsController@edit']);
                    Route::get('{id}/destroy', ['as' => 'clients.destroy', 'uses' => 'ClientsController@destroy']);
                    Route::get('create', ['as' => 'clients.create', 'uses' => 'ClientsController@create']);
                    Route::post('', ['as' => 'clients.store', 'uses' => 'ClientsController@store']);
                    Route::put('{id}', ['as' => 'clients.update', 'uses' => 'ClientsController@update']);
                    Route::get('group/{groupId}', ['as' => 'clients.byGroup', 'uses' => 'ClientsController@byGroup']);
                });

                Route::group(['prefix' => 'groups'], function () {
                    Route::get('', ['as' => 'groups.index', 'uses' => 'GroupsController@index']);
                    Route::get('{id}/edit', ['as' => 'groups.edit', 'uses' => 'GroupsController@edit']);
                    Route::get('{id}/destroy', ['as' => 'groups.destroy', 'uses' => 'GroupsController@destroy']);
                    Route::get('create', ['as' => 'groups.create', 'uses' => 'GroupsController@create']);
                    Route::post('', ['as' => 'groups.store', 'uses' => 'GroupsController@store']);
                    Route::put('{id}', ['as' => 'groups.update', 'uses' => 'GroupsController@update']);
                });

                Route::group(['prefix' => 'users'], function () {
                    Route::get('', ['as' => 'users.index', 'uses' => 'UsersController@index']);
                    Route::get('{id}/edit', ['as' => 'users.edit', 'uses' => 'UsersController@edit']);
                    Route::get('{id}/destroy', ['as' => 'users.destroy', 'uses' => 'UsersController@destroy']);
                    Route::get('create', ['as' => 'users.create', 'uses' => 'UsersController@create']);
                    Route::post('', ['as' => 'users.store', 'uses' => 'UsersController@store']);
                    Route::put('{id}', ['as' => 'users.update', 'uses' => 'UsersController@update']);
                    Route::put('{id}/value', ['as' => 'users.update.value', 'uses' => 'UsersController@updateValue']);
                    Route::get('change-pass', ['as' => 'users.changePassEdit','uses' => 'UsersController@changePassEdit']);
                    Route::post('change-pass', ['as' => 'users.changePassUpdate','uses' => 'UsersController@changePassUpdate']);
                    Route::post('/change/avatar', ['as' => 'users.changeAvatar','uses' => 'UsersController@changeAvatar']);
                    Route::get('{id}/restore', ['as' => 'users.restore', 'uses' => 'UsersController@restore']);
                    Route::get('{id}/contracts',['as'=>'users.contracts','uses'=>'ContractsController@contracts']);
                    Route::post('{id}/contracts/create',['as'=>'users.contracts.create','uses' =>'ContractsController@store']);
                    Route::post('/contracts/edit/{id}',['as'=>'users.contracts.update','uses' =>'ContractsController@update']);
                    Route::get('/contracts/{id}/destroy',['as'=>'users.contracts.destroy','uses' =>'ContractsController@delete']);
                    Route::post('{id}/generate/key',['as'=>'users.generate.key','uses'=> 'UsersController@generateKey']);
                });

                Route::group(['prefix' => 'projects'], function () {
                    Route::get('', ['as' => 'projects.index', 'uses' => 'ProjectsController@index']);
                    Route::get('{id}/edit', ['as' => 'projects.edit', 'uses' => 'ProjectsController@edit']);
                    Route::get('{id}/destroy', ['as' => 'projects.destroy', 'uses' => 'ProjectsController@destroy']);
                    Route::get('create', ['as' => 'projects.create', 'uses' => 'ProjectsController@create']);
                    Route::get('{id}/proposal-values-description/', ['as' => 'projects.descriptionValues.index', 'uses' => 'ProjectsController@proposalValuesIndex']);                    
                    Route::get('{id}/proposal-values-description/create', ['as' => 'projects.descriptionValues.create', 'uses' => 'ProjectsController@proposalValuesCreate']);
                    Route::get('{proposalValuesDescriptionId}/proposal-values-description/edit', ['as' => 'projects.descriptionValues.edit', 'uses' => 'ProjectsController@proposalValuesEdit']);
                    Route::put('{proposalValuesDescriptionId}/proposal-values-description/edit', ['as' => 'projects.descriptionValues.update', 'uses' => 'ProjectsController@proposalValuesUpdate']);
                    Route::get('{projectId}/proposal-values-description/{projectProposalValueId}/destroy', ['as' => 'projects.descriptionValues.destroy', 'uses' => 'ProjectsController@proposalValuesDestroy']);
                    Route::post('', ['as' => 'projects.store','uses' => 'ProjectsController@store'])->middleware('project-has-created');
                    Route::post('{id}/proposal-values-description/store', ['as' => 'projects.descriptionValues.store','uses' => 'ProjectsController@proposalValuesStore']);
                    Route::put('{id}/tasks', ['as' => 'projects.tasks.store','uses' => 'ProjectsController@storeTasks']);
                    Route::get('{id}/tasks', ['as' => 'projects.tasks', 'uses' => 'ProjectsController@tasks']);
                    Route::put('{id}', ['as' => 'projects.update', 'uses' => 'ProjectsController@update']);
                    Route::get('{id}/show', ['as' => 'projects.show', 'uses' => 'ProjectsController@show']);
                    Route::get('{id}/members-to-add', ['as' => 'projects.membersToAdd','uses' => 'ProjectsController@membersToAdd']);
                    Route::post('{id}/members', ['as' => 'projects.addMember','uses' => 'ProjectsController@addMember']);
                    Route::get('{id}/members', ['as' => 'projects.members', 'uses' => 'ProjectsController@members']);
                    Route::get('{id}/members/{member}/destroy', ['as' => 'projects.removeMember','uses' => 'ProjectsController@removeMember']);
                    Route::get('{id}/members/{member}/addhours', ['as' => 'projects.changehoursps','uses' => 'ProjectsController@changeHoursPs']);
                    Route::get('{id}/tasks-to-add', ['as' => 'projects.tasksToAdd','uses' => 'ProjectsController@tasksToAdd']);
                    Route::put('{id}/update/extra-expenses', ['as' => 'projects.updateExtraExpenses','uses' => 'ProjectsController@updateExtraExpenses']);
                    Route::get('{id}/restore', ['as' => 'projects.restore', 'uses' => 'ProjectsController@restore']);
                    Route::get('{id}/proposal-values-description/report', ['as' => 'projects.descriptionValues.report', 'uses' => 'ProjectsController@proposalValuesDescriptionReport']);     
                });

                Route::group(['prefix' => 'financial-ratings'], function () {
                    Route::get('', ['as' => 'financialRatings.index', 'uses' => 'FinancialRatingsController@index']);
                    Route::get('{id}/edit', ['as' => 'financialRatings.edit','uses' => 'FinancialRatingsController@edit']);
                    Route::get('{id}/destroy', ['as' => 'financialRatings.destroy','uses' => 'FinancialRatingsController@destroy']);
                    Route::get('create', ['as' => 'financialRatings.create','uses' => 'FinancialRatingsController@create']);
                    Route::post('', ['as' => 'financialRatings.store', 'uses' => 'FinancialRatingsController@store']);
                    Route::put('{id}', ['as' => 'financialRatings.update','uses' => 'FinancialRatingsController@update']);
                });

                Route::group(['prefix' => 'tasks'], function () {
                    Route::get('', ['as' => 'tasks.index', 'uses' => 'TasksController@index']);
                    Route::get('{id}/edit', ['as' => 'tasks.edit', 'uses' => 'TasksController@edit']);
                    Route::get('{id}/destroy', ['as' => 'tasks.destroy', 'uses' => 'TasksController@destroy']);
                    Route::get('create', ['as' => 'tasks.create', 'uses' => 'TasksController@create']);
                    Route::post('', ['as' => 'tasks.store', 'uses' => 'TasksController@store']);
                    Route::put('{id}', ['as' => 'tasks.update', 'uses' => 'TasksController@update']);
                });


                Route::group(['prefix' => 'activities'], function () {
                    Route::get('', ['as' => 'activities.index', 'uses' => 'ActivitiesController@index']);
                    Route::get('{id}/destroy', ['as' => 'activities.destroy','uses' => 'ActivitiesController@destroy']);
                    Route::get('create', ['as' => 'activities.create', 'uses' => 'ActivitiesController@create']);
                    Route::post('', ['as' => 'activities.store', 'uses' => 'ActivitiesController@store']);
                    Route::get('{id}/approve', ['as' => 'activities.approve','uses' => 'ActivitiesController@approve']);
                    Route::get('/external-works-report', ['as' => 'activities.externalWorksReport','uses' => 'ActivitiesController@externalWorksReport']);
                    Route::get('/{id}/download', ['as' => 'activities.download','uses' => 'ActivitiesController@downloadReport']);
                });

                Route::group(['prefix' => 'project-types'], function () {
                    Route::get('', ['as' => 'projectTypes.index', 'uses' => 'ProjectTypesController@index']);
                    Route::get('{id}/edit', ['as' => 'projectTypes.edit', 'uses' => 'ProjectTypesController@edit']);
                    Route::get('{id}/destroy', ['as' => 'projectTypes.destroy','uses' => 'ProjectTypesController@destroy']);
                    Route::get('create', ['as' => 'projectTypes.create', 'uses' => 'ProjectTypesController@create']);
                    Route::post('', ['as' => 'projectTypes.store', 'uses' => 'ProjectTypesController@store']);
                    Route::put('{id}', ['as' => 'projectTypes.update', 'uses' => 'ProjectTypesController@update']);
                    Route::get('{id}/tasks', ['as' => 'projectTypes.tasks', 'uses' => 'ProjectTypesController@tasks']);
                    Route::post('{id}/tasks', ['as' => 'projectTypes.addTask','uses' => 'ProjectTypesController@addTask']);
                    Route::get('{id}/tasks/{task}/destroy', ['as' => 'projectTypes.removeTask','uses' => 'ProjectTypesController@removeTask']);
                });

                Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
                    Route::get('', ['as' => 'index', 'uses' => 'RequestsController@index']);
                    Route::get('create', ['as' => 'create', 'uses' => 'RequestsController@create']);
                    Route::post('store', ['as' => 'store', 'uses' => 'RequestsController@store']);
                    Route::get('show/{id}', ['as' => 'show', 'uses' => 'RequestsController@show']);
                    Route::get('approve/{id}', ['as' => 'approve', 'uses' => 'RequestsController@approve']);
                    Route::post('refuse/{id}', ['as' => 'refuse', 'uses' => 'RequestsController@refuse']);
                });

                Route::group(['prefix' => 'missing-activities', 'as' => 'missingActivities.'], function () {
                    Route::get('', ['as' => 'index', 'uses' => 'MissingActivitiesController@index']);
                });

                Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {
                    Route::get('', ['as' => 'index', 'uses' => 'ExpensesController@index']);
                    Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'ExpensesController@edit']);
                    Route::get('{id}/destroy', ['as' => 'destroy', 'uses' => 'ExpensesController@destroy']);
                    Route::get('create', ['as' => 'create', 'uses' => 'ExpensesController@create']);
                    Route::post('', ['as' => 'store', 'uses' => 'ExpensesController@store']);
                    Route::put('{id}', ['as' => 'update', 'uses' => 'ExpensesController@update']);
                    Route::get('users/{requestId}', ['as' => 'usersByRequestId','uses' => 'ExpensesController@getUsersById']);
                    Route::get('/{date}/date', ['as' => 'dates', 'uses' => 'ExpensesController@getPairsByDate']);
                    Route::get('/report/txt', ['as' => 'report.txt', 'uses' => 'ExpensesController@reportTxt']);
                    Route::get('paymentWriteOffs',['as'=>'paymentWriteOffs','uses' =>'ExpensesController@paymentWriteOffs']);
                    Route::get('apportionments',['as'=>'apportionments','uses' =>'ExpensesController@apportionments']);
                });

                Route::group(['prefix' => 'expense-types'], function () {
                    Route::get('', ['as' => 'expenseTypes.index', 'uses' => 'ExpenseTypesController@index']);
                    Route::get('create', ['as' => 'expenseTypes.create', 'uses' => 'ExpenseTypesController@create']);
                    Route::post('', ['as' => 'expenseTypes.store', 'uses' => 'ExpenseTypesController@store']);
                    Route::get('{id}/edit', ['as' => 'expenseTypes.edit', 'uses' => 'ExpenseTypesController@edit']);
                    Route::put('{id}', ['as' => 'expenseTypes.update', 'uses' => 'ExpenseTypesController@update']);
                    Route::get('{id}/destroy', ['as' => 'expenseTypes.destroy','uses' => 'ExpenseTypesController@destroy']);
                    Route::get('/{id}/descriptions', ['as' => 'expenseTypes.descriptions','uses' => 'ExpenseTypesController@getPairsDescriptions']);
                });

                Route::group(['prefix' => 'debit-memos', 'as' => 'debitMemos.'], function () {
                    Route::get('', ['as' => 'index', 'uses' => 'DebitMemosController@index']);
                    Route::post('', ['as' => 'store', 'uses' => 'DebitMemosController@store']);
                    Route::get('/{id}/show', ['as' => 'show', 'uses' => 'DebitMemosController@show']);
                    Route::get('/{id}/show/report', ['as' => 'showReport','uses' => 'DebitMemosController@showReport']);
                    Route::get('/{id}/close', ['as' => 'close', 'uses' => 'DebitMemosController@close']);
                    Route::put('/{id}/edit', ['as' => 'update', 'uses' => 'DebitMemosController@update']);
                    Route::post('/{id}/store/alert', ['as' => 'store.alert','uses' => 'DebitMemosController@storeAlert']);
                    Route::get('{id}/store/alert/{alertId}', ['as' => 'destroy.alert','uses' => 'DebitMemosController@destroyAlert']);
                });

                Route::group(['prefix' => 'reports/performance','as' => 'reports.','middleware' => ['is-download']], function () {
                    Route::get('/owners', ['as' => 'owners.index', 'uses' => 'ReportsController@ownersIndex']);
                    Route::get('/users', ['as' => 'users.index', 'uses' => 'ReportsController@usersIndex']);
                });

                Route::group(['prefix' => 'reports/budgeted-vs-actual', 'as' => 'reports.'], function () {
                    Route::get('/', ['as' => 'budgetedVsActual.index', 'uses' => 'BudgetedVsActualController@index']);
                });

                Route::group(['prefix' => 'reports/gantt', 'as' => 'reports.gantt.'], function () {
                    Route::get('/resources', ['as' => 'indexResources', 'uses' => 'GanttController@indexResources']);
                    Route::get('/projects', ['as' => 'indexProjects', 'uses' => 'GanttController@indexProjects']);
                });

                Route::group(['prefix' => 'companies', 'as' => 'companies.'], function () {
                    Route::get('', ['as' => 'index', 'uses' => 'CompaniesController@index']);
                    Route::get('/create', ['as' => 'create', 'uses' => 'CompaniesController@create']);
                    Route::post('/create', ['as' => 'store', 'uses' => 'CompaniesController@store']);
                    Route::get('/{id}/edit', ['as' => 'edit', 'uses' => 'CompaniesController@edit']);
                    Route::put('/{id}/edit', ['as' => 'update', 'uses' => 'CompaniesController@update']);
                });

                Route::group(['prefix' => 'coast-users', 'as' => 'coastUsers.'], function () {
                    Route::get('', ['as' => 'index', 'uses' => 'CoastUsersController@index']);
                    Route::put('/{userID}/edit', ['as' => 'update', 'uses' => 'CoastUsersController@update']);
                    Route::get('/copy-last-values', ['as' => 'copyLastValues', 'uses' => 'CoastUsersController@copyLastValues']);
                });

                Route::group(['prefix' => 'events', 'as' => 'events.'], function () {
                    Route::get('', ['as' => 'index', 'uses' => 'EventsController@index']);
                    Route::get('/emails/{id}', ['as' => 'emails', 'uses' => 'EventsController@emails']);
                    Route::post('/emails/{id}', ['as' => 'addEmails', 'uses' => 'EventsController@addEmail']);
                    Route::get('/emails/{id}/remove/{userId}', ['as' => 'removeEmails','uses' => 'EventsController@removeEmail']);
                });

                Route::get('/select-plan', ['as' => 'selectPlan', 'uses' => 'SignaturesController@indexSelectPlan']);

            });

            Route::get('users/login', ['as' => 'users.login', 'uses' => 'UsersController@login']);
            Route::post('users/attempt', ['as' => 'users.attempt', 'uses' => 'UsersController@attempt']);

            Route::group(['prefix' => 'audits', 'as' => 'audits.'], function () {
                Route::get('', ['as' => 'index', 'uses' => 'AuditsController@index']);
                Route::get('{id}/show', ['as' => 'show', 'uses' => 'AuditsController@show']);
            });

            Route::group(['prefix' => 'holidays', 'as' => 'holidays.'], function () {
                Route::get('', ['as' => 'index', 'uses' => 'HolidaysController@index']);
                Route::get('create', ['as' => 'create', 'uses' => 'HolidaysController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'HolidaysController@store']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'HolidaysController@edit']);
                Route::get('{id}/destroy', ['as' => 'destroy', 'uses' => 'HolidaysController@destroy']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'HolidaysController@update']);
            });

            Route::group(['prefix' => 'airports'], function () {
                Route::get('', ['as' => 'airports.index', 'uses' => 'AirportsController@index']);
                Route::get('{id}/edit', ['as' => 'airports.edit', 'uses' => 'AirportsController@edit']);
                Route::get('{id}/destroy', ['as' => 'airports.destroy', 'uses' => 'AirportsController@destroy']);
                Route::get('create', ['as' => 'airports.create', 'uses' => 'AirportsController@create']);
                Route::post('', ['as' => 'airports.store', 'uses' => 'AirportsController@store']);
                Route::put('{id}', ['as' => 'airports.update', 'uses' => 'AirportsController@update']);
            });

            Route::group(['prefix' => 'states'], function () {
                Route::get('', ['as' => 'states.index', 'uses' => 'StatesController@index']);
                Route::get('{id}/edit', ['as' => 'states.edit', 'uses' => 'StatesController@edit']);
                Route::get('{id}/destroy', ['as' => 'states.destroy', 'uses' => 'StatesController@destroy']);
                Route::get('create', ['as' => 'states.create', 'uses' => 'StatesController@create']);
                Route::post('', ['as' => 'states.store', 'uses' => 'StatesController@store']);
                Route::put('{id}', ['as' => 'states.update', 'uses' => 'StatesController@update']);
            });

            Route::group(['prefix' => 'cities'], function () {
                Route::get('', ['as' => 'cities.index', 'uses' => 'CitiesController@index']);
                Route::get('{id}/edit', ['as' => 'cities.edit', 'uses' => 'CitiesController@edit']);
                Route::get('{id}/destroy', ['as' => 'cities.destroy', 'uses' => 'CitiesController@destroy']);
                Route::get('create', ['as' => 'cities.create', 'uses' => 'CitiesController@create']);
                Route::post('', ['as' => 'cities.store', 'uses' => 'CitiesController@store']);
                Route::put('{id}', ['as' => 'cities.update', 'uses' => 'CitiesController@update']);
                Route::get('state/{stateId}', ['as' => 'cities.byState', 'uses' => 'CitiesController@byState']);
            });

            Route::group(['prefix' => 'transportation-facilities'], function () {
                Route::get('', ['as' => 'transportationFacilities.index','uses' => 'TransportationFacilitiesController@index']);
                Route::get('{id}/edit', ['as' => 'transportationFacilities.edit','uses' => 'TransportationFacilitiesController@edit']);
                Route::get('{id}/destroy', ['as' => 'transportationFacilities.destroy','uses' => 'TransportationFacilitiesController@destroy']);
                Route::get('create', ['as' => 'transportationFacilities.create','uses' => 'TransportationFacilitiesController@create']);
                Route::post('', ['as' => 'transportationFacilities.store','uses' => 'TransportationFacilitiesController@store']);
                Route::put('{id}', ['as' => 'transportationFacilities.update','uses' => 'TransportationFacilitiesController@update']);
            });

            Route::group(['prefix' => 'carTypes'], function () {
                Route::get('', ['as' => 'carTypes.index', 'uses' => 'CarTypesController@index']);
                Route::get('{id}/edit', ['as' => 'carTypes.edit', 'uses' => 'CarTypesController@edit']);
                Route::get('{id}/destroy', ['as' => 'carTypes.destroy', 'uses' => 'CarTypesController@destroy']);
                Route::get('create', ['as' => 'carTypes.create', 'uses' => 'CarTypesController@create']);
                Route::post('', ['as' => 'carTypes.store', 'uses' => 'CarTypesController@store']);
                Route::put('{id}', ['as' => 'carTypes.update', 'uses' => 'CarTypesController@update']);
            });

            Route::group(['prefix' => 'places'], function () {
                Route::get('', ['as' => 'places.index', 'uses' => 'PlacesController@index']);
                Route::get('{id}/edit', ['as' => 'places.edit', 'uses' => 'PlacesController@edit']);
                Route::get('{id}/destroy', ['as' => 'places.destroy', 'uses' => 'PlacesController@destroy']);
                Route::get('create', ['as' => 'places.create', 'uses' => 'PlacesController@create']);
                Route::post('', ['as' => 'places.store', 'uses' => 'PlacesController@store']);
                Route::put('{id}', ['as' => 'places.update', 'uses' => 'PlacesController@update']);
            });

            Route::group(['prefix' => 'permissions'], function () {
                Route::get('', ['as' => 'permissions.index', 'uses' => 'PermissionsController@index']);
                Route::get('{id}/edit', ['as' => 'permissions.edit', 'uses' => 'PermissionsController@edit']);
                Route::get('{id}/destroy', ['as' => 'permissions.destroy', 'uses' => 'PermissionsController@destroy']);
                Route::get('create', ['as' => 'permissions.create', 'uses' => 'PermissionsController@create']);
                Route::post('', ['as' => 'permissions.store', 'uses' => 'PermissionsController@store']);
                Route::put('{id}', ['as' => 'permissions.update', 'uses' => 'PermissionsController@update']);
            });

            Route::group(['prefix' => 'roles'], function () {
                Route::get('', ['as' => 'roles.index', 'uses' => 'RolesController@index']);
                Route::get('{id}/edit', ['as' => 'roles.edit', 'uses' => 'RolesController@edit']);
                Route::get('{id}/destroy', ['as' => 'roles.destroy', 'uses' => 'RolesController@destroy']);
                Route::get('create', ['as' => 'roles.create', 'uses' => 'RolesController@create']);
                Route::post('', ['as' => 'roles.store', 'uses' => 'RolesController@store']);
                Route::put('{id}', ['as' => 'roles.update', 'uses' => 'RolesController@update']);
                Route::get('{id}/permissions', ['as' => 'roles.permissions', 'uses' => 'RolesController@permissions']);
                Route::post('{id}/addPermission', ['as' => 'roles.addPermission','uses' => 'RolesController@addPermission']);
                Route::get('{id}/permissions/{permission}/destroy', ['as' => 'roles.removePermission', 'uses' => 'RolesController@removePermission']);
            });

            Route::group(['prefix' => 'modules', 'as' => 'modules.'], function () {
                Route::get('', ['as' => 'index', 'uses' => 'ModulesController@index']);
                Route::get('/create', ['as' => 'create', 'uses' => 'ModulesController@create']);
                Route::post('/create', ['as' => 'store', 'uses' => 'ModulesController@store']);
                Route::get('/{id}/edit', ['as' => 'edit', 'uses' => 'ModulesController@edit']);
                Route::put('/{id}/edit', ['as' => 'update', 'uses' => 'ModulesController@update']);
                Route::get('/{id}/delete', ['as' => 'destroy', 'uses' => 'ModulesController@destroy']);
                Route::get('{id}/permissions', ['as' => 'permissions', 'uses' => 'ModulesController@permissions']);
                Route::post('{id}/addPermission', ['as' => 'addPermission','uses' => 'ModulesController@addPermission']);
                Route::get('{id}/permissions/{permission}/destroy', ['as' => 'removePermission','uses' => 'ModulesController@removePermission']);

            });

            Route::group(['prefix' => 'plans', 'as' => 'plans.'], function () {
                Route::get('', ['as' => 'index', 'uses' => 'PlansController@index']);
                Route::get('/create', ['as' => 'create', 'uses' => 'PlansController@create']);
                Route::post('/create', ['as' => 'store', 'uses' => 'PlansController@store']);
                Route::get('/{id}/edit', ['as' => 'edit', 'uses' => 'PlansController@edit']);
                Route::put('/{id}/edit', ['as' => 'update', 'uses' => 'PlansController@update']);
                Route::get('/{id}/delete', ['as' => 'delete', 'uses' => 'PlansController@destroy']);
                Route::get('/{id}/modules', ['as' => 'modules', 'uses' => 'PlansController@modules']);
                Route::post('{id}/add-modules', ['as' => 'addModules', 'uses' => 'PlansController@addModules']);
                Route::get('{id}/modules/{idModule}/destroy', ['as' => 'removeModule','uses' => 'PlansController@removeModule']);
            });

            Route::group(['prefix' => 'groups/companies', 'as' => 'groupCompanies.'], function () {
                Route::get('', ['as' => 'index', 'uses' => 'GroupCompaniesController@index']);
                Route::get('/create', ['as' => 'create', 'uses' => 'GroupCompaniesController@create']);
                Route::post('/create', ['as' => 'store', 'uses' => 'GroupCompaniesController@store']);
                Route::get('/{id}/edit', ['as' => 'edit', 'uses' => 'GroupCompaniesController@edit']);
                Route::put('/{id}/edit', ['as' => 'update', 'uses' => 'GroupCompaniesController@update']);
            });

            Route::group(['prefix' => 'bank-slips', 'as' => 'bankSlips.'], function () {
                Route::get('/', ['as' => 'index', 'uses' => 'BankSlipsController@index']);
                Route::get('/{id}/upload', ['as' => 'upload', 'uses' => 'BankSlipsController@edit']);
                Route::get('/{id}/approve', ['as' => 'approve', 'uses' => 'BankSlipsController@approve']);
                Route::post('/{id}/upload/store', ['as' => 'upload.store', 'uses' => 'BankSlipsController@update']);
                Route::get('/{id}/delete', ['as' => 'destroy', 'uses' => 'BankSlipsController@destroy']);
            });

            Route::get('/notifications', ['as' => 'notifications.index', 'uses' => 'NotificationsController@index']);
            Route::post('/change-companies', ['as' => 'changeCompanies', 'uses' => 'UsersController@changeCompanies']);
            Route::post('/change-group-companies', ['as' => 'changeGroupCompanies','uses' => 'UsersController@changeGroupCompanies']);

            Route::group(['prefix' => '/signatures', 'as' => 'signatures.'], function () {
                Route::get('/', ['as' => 'index', 'uses' => 'SignaturesController@index']);
                Route::get('/signatures/cancellation', ['as' => 'cancellation','uses' => 'SignaturesController@cancellation']);
            });

            Route::get('/change-plan/{id}/store', ['as' => 'planSelected', 'uses' => 'SignaturesController@storePlan']);

            Route::get('/checkout', ['as' => 'checkout.index', 'uses' => 'CheckoutController@index']);
            Route::post('/checkout/store', ['as' => 'checkout.store', 'uses' => 'CheckoutController@store']);

        
        });

        Route::group(['prefix'=>'revenues','as' =>'revenues.'], function(){
            Route::get('/',['as'=>'index','uses' => 'RevenuesController@index']);
        });


        Route::group(['prefix' => 'import','as'=>'imports.'], function () {
            Route::get('/',['as'=>'index','uses' => 'ImportsController@index']);
            Route::post('/upload',['as'=>'upload','uses' => 'ImportsController@upload']);
            Route::get('/importar',['as'=>'importar','uses' => 'ImportsController@importar']);
        });

        Route::group(['prefix'=>'providers','as'=>'providers.'],function(){
            Route::get('/',['as' =>'index','uses'=>'ProvidersController@index']);
            Route::get('/create',['as'=>'create',"uses" => "ProvidersController@create"]);
            Route::post('/create',['as'=>'create',"uses" => "ProvidersController@store"]);
            Route::get('{id}/edit',['as' =>'edit',"uses" =>"ProvidersController@edit"]);    
            Route::post('{id}/edit',['as'=>'update','uses'=>'ProvidersController@update']);
            Route::get('{id}/destroy',['as'=>'destroy','uses' =>'ProvidersController@destroy']);
        });

       Route::get('/development',function(){
           return view('development');
       });

       Route::group(['prefix' => 'supplier-expenses','as' => 'supplierExpense.'], function () {
           Route::get('',['as'=>'index','uses'=>'SupplierExpensesController@index']);
           Route::get('/create',['as'=>'create','uses'=>'SupplierExpensesController@create']);
           Route::post('/store',['as'=>'store','uses'=>'SupplierExpensesController@store']);
           Route::get('{id}/edit',['as'=>'edit','uses'=>'SupplierExpensesController@edit']);
           Route::put('{id}', ['as' => 'update', 'uses' => 'SupplierExpensesController@update']);
           Route::get('{id}/destroy',['as' => 'destroy', 'uses' => 'SupplierExpensesController@destroy']);
           Route::get('{id}/providers',['as'=>'providers', 'uses' =>'SupplierExpensesController@providers']);
           Route::get('paymentWriteOffs',['as'=>'paymentWriteOffs','uses' =>'SupplierExpensesController@paymentWriteOffs']);
           Route::get('apportionments',['as'=>'apportionments','uses' =>'ExpensesController@apportionments']);
       });

       Route::group(['prefix' => 'supplier-expenses-imports', 'as' => 'supplierExpensesImport.'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'SupplierExpensesImportsController@index']);
        Route::post('/store', ['as' => 'store', 'uses' => 'SupplierExpensesImportsController@store']);
        });

       Route::group(['prefix'=>'app-versions','as' => 'appVersions.'],function(){
            Route::get('',['as'=>'index','uses' =>'AppVersionsController@index']);
            Route::post('',['as'=>'store','uses' => 'AppVersionsController@store']);
       });

       Route::group(['prefix' =>'payment-user','as'=>'payment.'],function(){
            Route::get('',['as' =>'index','uses' =>'PaymentController@index']);
            Route::post('',['as'=>'store','uses'=>'PaymentController@store']);
            Route::get('{id}/destroy',['as'=>'destroy','uses' =>'PaymentController@destroy']);
            Route::get('{id}/edit',['as'=>'edit','uses' =>'PaymentController@edit']);
            Route::post('{id}',['as'=>'update','uses' =>'PaymentController@update']);
       });

       Route::group(['prefix' =>'payment-provider','as'=>'paymentProvider.'],function(){
        Route::get('',['as' =>'index','uses' =>'PaymentTypeProvidersController@index']);
        Route::post('',['as'=>'store','uses'=>'PaymentTypeProvidersController@store']);
        Route::get('{id}/destroy',['as'=>'destroy','uses' =>'PaymentTypeProvidersController@destroy']);
        Route::get('{id}/edit',['as'=>'edit','uses' =>'PaymentTypeProvidersController@edit']);
        Route::post('{id}',['as'=>'update','uses' =>'PaymentTypeProvidersController@update']);
        });
    });