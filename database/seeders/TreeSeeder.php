<?php

namespace Database\Seeders;

use App\Models\Tree;
use Illuminate\Database\Seeder;

class TreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Tree::factory()->count(10)->create();
    }
}
