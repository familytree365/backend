<?php

namespace Database\Seeders;

use App\Models\Subn;
use Illuminate\Database\Seeder;

class SubnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Subn::factory()->count(5)->create();
    }
}
