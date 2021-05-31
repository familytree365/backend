<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tenant::checkCurrent()
           ? $this->runTenantSpecificSeeders()
           : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {
        // run tenant specific seeders
    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders
        $this->call(RolesAndPermissionsSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(CompanySeeder::class);
        // $this->call(UserCompanySeeder::class);
        // $this->call(TreeSeeder::class);
        // $this->call(TenantSeeder::class);
        // $this->call(GeneanumSeeder::class);
    }
}
