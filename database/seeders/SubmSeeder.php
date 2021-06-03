<?php

namespace Database\Seeders;

use App\Models\Subm;
use Illuminate\Database\Seeder;

class SubmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Subm::factory()->count(5)->create();
    }
}
