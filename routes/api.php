<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'expenses','middleware' => 'auth:api'], function() {
    
    Route::post("/create","Api\ExpensesApiController@store");
    Route::get("/user/{iduser}","Api\ExpensesApiController@showall");
    Route::get("/expense/{id}","Api\ExpensesApiController@show");
    Route::post("/expense/{id}","Api\ExpensesApiController@update");
    Route::delete("/expense/{id}","Api\ExpensesApiController@delete");
    Route::post("/project","Api\ProjectsApiController@showByUser");
    Route::get("/requests","Api\RequestsApiController@showByRequest");
    Route::get("/descriptions","Api\ExpensesApiController@showdescription");
   
});

Route::group(['prefix' => 'project','middleware' => 'auth:api'], function(){
    Route::get("{id}/tasks","Api\ProjectsApiController@tasks");
});

Route::group(['prefix' => 'payment', 'middleware' => 'auth:api'], function() {
    Route::get("/types","Api\PaymentsApiController@showByPaymenttypes");
});

Route::group(['prefix'=>'request', 'middleware' => 'auth:api'],function(){
    Route::post("/requests","Api\RequestsApiController@showByRequest");
});

Route::group(['prefix' => 'auth' ], function() {
    Route::post('login', 'Api\AuthApiController@login');
    Route::post('signup', 'Api\AuthApiController@signup');


    Route::group([
        'middleware' =>  'auth:api'
      ], function() {
          Route::get('logout', 'Api\AuthApiController@logout');
          Route::get('user', 'Api\AuthApiController@user');
          Route::get('activities','ActivitiesController@activitiesByUser');
      });
});

Route::group(['prefix' => 'users','middleware' => 'auth:api'], function () {
    Route::get('{id}/activities','Api\ActivitiesApiController@activitiesByUser');
    
});

Route::group(['prefix' => 'activities','middleware' => 'auth:api'], function () {
    Route::post('/create','Api\ActivitiesApiController@store');
});

Route::group(['prefix' => 'places', 'middleware' => 'auth:api'], function () {
    Route::get('/','Api\PlaceApiController@show');
});


Route::group(['prefix' => 'license'],function(){
    

    Route::group([ 'middleware' =>  ['auth:api']], function () {
        Route::post('/','Api\LicenseController@license');
        Route::post('/create','Api\LicenseController@create');    
    });
});

Route::group(['prefix'=>'app','middleware' => 'auth:api'],function(){
    Route::get('/version/last','Api\AppVersionApiController@last');
});
