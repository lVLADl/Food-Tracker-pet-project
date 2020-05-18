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
        $api->any('/', ['as' => 'p', 'uses' => 'App\Http\Controllers\UserController@getMealPlan']);
    });
    $api->get('/admin', function () {
    });
    $api->group([], function (\Dingo\Api\Routing\Router $api) {
        $api->post('/auth/login', 'App\Http\Controllers\AuthController@login')->name('login');
        $api->post('/auth/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
        $api->get('/auth/refresh', 'App\Http\Controllers\AuthController@refresh')->name('refresh');
        $api->get('/auth/me', 'App\Http\Controllers\AuthController@me')->name('me');
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
