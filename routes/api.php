<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function(\Dingo\Api\Routing\Router $api) {
    $api->group([], function (\Dingo\Api\Routing\Router $api) {
        $api->post('/dishes', 'App\Http\Controllers\DishController@store'); # store
        $api->get('/dishes', 'App\Http\Controllers\DishController@index'); # index
        $api->get('/dishes/{dish}', 'App\Http\Controllers\DishController@show'); # show
        $api->put('/dishes/{dish}', 'App\Http\Controllers\DishController@update'); # update
        $api->get('/dishes/{dish}/approve', 'App\Http\Controllers\DishController@approve'); # approve
    });
//    $api->get('/admin', function () {});
    $api->group([], function (\Dingo\Api\Routing\Router $api) {
        $api->get('/user', 'App\Http\Controllers\AuthController@me')->name('me');
        $api->post('/user/login', 'App\Http\Controllers\AuthController@login')->name('login');
        $api->post('/user/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
        $api->get('/user/refresh', 'App\Http\Controllers\AuthController@refresh')->name('refresh');
        $api->get('/user/meal_plan', 'App\Http\Controllers\AuthController@getMealPlan')->name('meal_plan');
        $api->get('/user/calories_intake', 'App\Http\Controllers\AuthController@calculateDailyCaloriesIntake')->name('calories_daily_intake');
    });
});

/*
Route::group(['middleware' => ['api.auth']], function() {
    Route::group([], function() {
        Route::any('/', ['as' => 'p', 'uses' => 'App\Http\Controllers\UserController@getMealPlan']);
    });
    Route::get('/admin', function() {});
    Route::group(['prefix' => 'auth'], function() {
        Route::post('/login', 'AuthController@login')->name('index');
        Route::get('/refresh', 'AuthController@refresh')->name('refresh');
        Route::get('/me', 'AuthController@me')->name('me');
    });
});
# Route::post('auth/logout', 'AuthController@logout')->name('logout');
*/
