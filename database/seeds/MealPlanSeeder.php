<?php

use Illuminate\Database\Seeder;
use App\Models\MealPlan;

class MealPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        MealPlan::create([
            'sex' => MealPlan::$SEX['MEN'],
            'weight' => 58,
            'height' => 188,
            'weight_goal' => 50,
            'age' => 18,
            'activity_rate' => MealPlan::$COEFFICIENTS['XL'],
            'calories_change' => 20,
            'user_id' => \App\Models\User::all()->where('email', 'user@gmail.com')
        ]);
        # factory(App\Models\MealPlan::class, 1)->create();
        /* foreach (\Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw("SELECT id FROM USERS WHERE ID NOT IN (SELECT USER_ID FROM MEAL_PLANS)")) as $user)
            \App\Models\MealPlan::create([
                'sex' => $sex=$faker->randomElement([MealPlan::$SEX['MEN'], MealPlan::$SEX['WOMAN']]),
                'weight' => $weight=($sex==MealPlan::$SEX['MEN']?random_int(50, 110):random_int(50, 80)),
                'height' => random_int(150, 210),
                'weight_goal' => random_int(1, 10)%2==0?$weight-random_int(5, 30):$weight+random_int(5, 30),
                'age' => random_int(16, 70),
                'activity_rate' => $faker->randomElement(MealPlan::$COEFFICIENTS),
                'calories_change' => random_int(0, 26),
                'user_id' => $user->id
            ]);
        */
    }
}
