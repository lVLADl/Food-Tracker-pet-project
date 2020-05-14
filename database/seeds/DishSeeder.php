<?php

use Illuminate\Database\Seeder;
use \App\Models\Meal;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::all()->where('email', 'user@gmail.com')->first();

        # title/calories/proteins/fats/carbohydrates/user_id
        $m = [
            ['Rice', 344, 6.7, 0.7, 78.9, ],
            ['Toast', 242, 8.1, 1.0, 48.8, ],
            ['Boiled chicken', 170, 25.2, 7.4, 0, ],
        ];
        foreach ($m as $m_arr) {
            Meal::create([
                'title' => $m_arr[0],
                'calories' => $m_arr[1],
                'proteins' => $m_arr[2],
                'fats' => $m_arr[3],
                'carbohydrates' => $m_arr[4],
                'user_id' => $user->id,
            ]);
        }
    }
}
