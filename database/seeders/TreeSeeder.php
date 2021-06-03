<?php

namespace Database\Seeders;

use App\Models\Tree;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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
        // $faker = Faker::create();
        // $tree = new Tree();
        // $tree->company_id = 1;
        // $tree->current_tenant = '1';
        // $tree->name = 'tree';
        // $tree->description = 'Description for tree';
        // $tree->save();

        // for ($i = 0; $i < 10; $i++){
        //     $tree = new Tree();
        //     $tree->company_id = 1;
        //     $tree->current_tenant = $faker->randomNumber(2);
        //     $tree->name = $faker->name;
        //     $tree->description = $faker->sentence;
        //     $tree->save();
        // }
    }
}
