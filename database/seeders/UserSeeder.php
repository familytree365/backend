<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::create([
            'first_name' => 'Tester',
            'last_name' => 'Tester',
            'email' => 'test@test.com',
            'password' => bcrypt('test@123')
        ]);
        User::create([
            'first_name' => 'Second',
            'last_name' => 'Tester',
            'email' => 'second@test.com',
            'password' => bcrypt('test@123')
        ]);
    }

}
