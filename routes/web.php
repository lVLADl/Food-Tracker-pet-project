<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $faker = Faker\Factory::create();
    $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker)); // meal-provider

    $user = \App\Models\User::find(1);
    return response()->json(\App\Models\Meal::select('*')->whereDate('created_at', '=', \Illuminate\Support\Carbon::yesterday()->toDateString())->get());
    return $user->created_at->eq(\Carbon\Carbon::yesterday()->toDateString()) ? 'true':'false';
    return response()->json($user->created_at->lt(\Carbon\Carbon::today()));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
