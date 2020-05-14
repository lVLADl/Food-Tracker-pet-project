<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Dish::class, function (Faker $faker) {
    $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker)); // meal-provider
    return [
        'title',
        'calories',
        'proteins',
        'fats',
        'carbohydrates',
        'user_id'
    ];
});
