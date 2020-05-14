<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Models\MealPlan;
use Faker\Generator as Faker;

$factory->define(MealPlan::class, function (Faker $faker) {
    $user = $faker->randomElement(\Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw("SELECT id FROM USERS WHERE ID NOT IN (SELECT USER_ID FROM MEAL_PLANS)")));
    return [
        'sex' => $sex=$faker->randomElement([MealPlan::$SEX['MEN'], MealPlan::$SEX['WOMAN']]),
        'weight' => $weight=($sex==MealPlan::$SEX['MEN']?random_int(50, 110):random_int(50, 80)),
        'height' => random_int(150, 210),
        'weight_goal' => random_int(1, 10)%2==0?$weight-random_int(5, 30):$weight+random_int(5, 30),
        'age' => random_int(16, 70),
        'activity_rate' => $faker->randomElement(MealPlan::$COEFFICIENTS),
        'calories_change' => random_int(0, 26),
        'user_id' => $user->id
    ];
});
