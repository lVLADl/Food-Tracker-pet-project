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

    # Dish
    $api->group([], function (\Dingo\Api\Routing\Router $api) {
        $api->get('/dishes', 'App\Http\Controllers\DishController@index')->name('dish_index'); # index
        $api->post('/dishes', 'App\Http\Controllers\DishController@store')->name('dish_store'); # store

        $api->group(['middleware' => ['dish_access']], function(\Dingo\Api\Routing\Router $api) { #
            $api->get('/dishes/{dish}', 'App\Http\Controllers\DishController@show')->name('dish_show'); # show
            $api->put('/dishes/{dish}', 'App\Http\Controllers\DishController@update')->name('dish_update'); # update
            $api->delete('/dishes/{dish}', 'App\Http\Controllers\DishController@destroy')->name('dish_delete'); # delete
        });

        $api->get('/dishes/{dish}/approve', 'App\Http\Controllers\DishController@approve')->name('dish_approve')->middleware(['role:Admin']); # approve
    });

    # Meals
    $api->group(['middleware' => ['api.auth', ]], function (\Dingo\Api\Routing\Router $api) {
        $api->get('/meals', 'App\Http\Controllers\MealController@index');
        $api->post('/meals', 'App\Http\Controllers\MealController@store');
        $api->group(['middlewares' => ['meal_access']], function(\Dingo\Api\Routing\Router $api) {
            $api->get('/meals/{meal}', 'App\Http\Controllers\MealController@show');
            $api->put('/meals/{meal}', 'App\Http\Controllers\MealController@update');
            $api->delete('/meals/{meal}', 'App\Http\Controllers\MealController@destroy');
        });
    });

    # User
    $api->group([], function (\Dingo\Api\Routing\Router $api) {
        $api->get('/user', 'App\Http\Controllers\AuthController@me')->name('me');
        $api->post('/user', 'App\Http\Controllers\AuthController@register')->name('register');
        $api->post('/user/login', 'App\Http\Controllers\AuthController@login')->name('login');
        $api->post('/user/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
        $api->get('/user/refresh', 'App\Http\Controllers\AuthController@refresh')->name('refresh');
        $api->get('/user/meal_plan', 'App\Http\Controllers\AuthController@getMealPlan')->name('meal_plan');
        $api->get('/user/calories_intake', 'App\Http\Controllers\AuthController@calculateDailyCaloriesIntake')->name('calories_daily_intake');
    });
});
