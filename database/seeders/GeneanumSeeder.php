<?php

namespace Database\Seeders;

use App\Models\Geneanum;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GeneanumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $geneanum = new Geneanum();
        $geneanum->remote_id = '1';
        $geneanum->data = 'geneanum';
        $geneanum->area = 'UAE';
        $geneanum->db_name = 'Test';
        $geneanum->save();

        for ($i = 0; $i < 10; $i++){
            $geneanum = new Geneanum();
            $geneanum->remote_id = $faker->unique()->randomNumber(1);
            $geneanum->data = $faker->sentence;
            $geneanum->area = $faker->unique()->country;
            $geneanum->db_name = $faker->name;
            $geneanum->save();
        }
    }
}
