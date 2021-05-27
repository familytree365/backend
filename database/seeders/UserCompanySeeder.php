<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_company')->insert([
            'user_id' => 1,
            'company_id' => 1,
        ]);
        DB::table('user_company')->insert([
            'user_id' => 2,
            'company_id' => 2,
        ]);
        DB::table('user_company')->insert([
            'user_id' => 3,
            'company_id' => 3,
        ]);
        DB::table('user_company')->insert([
            'user_id' => 4,
            'company_id' => 4,
        ]);
    }
}
