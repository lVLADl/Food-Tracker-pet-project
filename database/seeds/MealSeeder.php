<?php

use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = \App\Models\User::all()->where('email', 'user@gmail.com')->first()->id;
        $titles = ['Rice', 'Toast', 'Boiled chicken'];
        $query = \App\Models\Dish::all();
        foreach ($titles as $title) {
            $dish_id = $query->where('title', $title)->first()->id;
            \App\Models\Meal::create([
                'dish_id' => $dish_id,
                'user_id' => $user_id
            ]);
        }
    }
}
