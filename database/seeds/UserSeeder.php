<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(\App\Models\User::all()->where('email', 'admin@gmail.com')->count() == 0) {
            \App\Models\User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => 'manager_passd_456'
            ])->assignRole('Admin');
        }
        if(\App\Models\User::all()->where('email', 'admin@gmail.com')->count() == 0) {
            \App\Models\User::create([
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => 'user_passd_123'
            ]);
        }

        # factory(App\Models\User::class, 20)->create();
    }
}
