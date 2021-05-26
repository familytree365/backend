<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant = new Tenant();
        $tenant->name = 'Tenant';
        $tenant->tree_id = '1';
        $tenant->database = 'This is a dummy database';
        $tenant->save();
    }
}
