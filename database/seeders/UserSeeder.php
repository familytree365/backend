<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::factory()->count(10)->create();
        // $faker = Faker::create();
        // $user = new User();
        // $user->first_name = 'John';
        // $user->last_name = 'Doe';
        // $user->email = 'admin@familytree365.com';
        // $user->password = Hash::make('password');
        // $user->save();
        // for ($i = 0; $i < 10; $i++) {
        //     $user = new User();
        //     $user->first_name = $faker->name;
        //     $user->last_name = $faker->name;
        //     $user->email = $faker->unique()->safeEmail;
        //     $user->password = Hash::make('password');
        //     $user->save();
        // }
    }
}
