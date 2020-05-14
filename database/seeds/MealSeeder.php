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
        $index = 1;
        $user = \App\Models\User::all()->where('email', 'user@gmail.com')->first();
        \App\Models\Meal::select('*')->whereDate('created_at', '=', \Illuminate\Support\Carbon::today()->toDateString())->get();
    }
}
