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
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


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
        'middleware' => 'auth:api'
      ], function() {
          Route::get('logout', 'Api\AuthApiController@logout');
          Route::get('user', 'Api\AuthApiController@user');
      });
});