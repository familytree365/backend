<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        $role = Role::create(['name' => 'free']);
		$role = Role::create(['name' => 'expired']);

        $role = Role::create(['name' => 'UTY']);
		$role = Role::create(['name' => 'UTM']);

        $role = Role::create(['name' => 'TTY']);
        $role = Role::create(['name' => 'TTM']);

        $role = Role::create(['name' => 'OTY']);
        $role = Role::create(['name' => 'OTM']);


        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
