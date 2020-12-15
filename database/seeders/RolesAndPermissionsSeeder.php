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

		$permissions = [
            ['name' => 'dashboard', 'guard_name' => 'web'],
            ['name' => 'calendar', 'guard_name' => 'web'],
            ['name' => 'files', 'guard_name' => 'web'],
            ['name' => 'information', 'guard_name' => 'web'],
            ['name' => 'sources', 'guard_name' => 'web'],
            ['name' => 'people', 'guard_name' => 'web'],
            ['name' => 'family', 'guard_name' => 'web'],
            ['name' => 'references', 'guard_name' => 'web'],
            ['name' => 'trees', 'guard_name' => 'web'],
            ['name' => 'forum', 'guard_name' => 'web'],
            ['name' => 'gedcom import', 'guard_name' => 'web'],
            ['name' => 'subscription', 'guard_name' => 'web'],
            ['name' => 'dna upload', 'guard_name' => 'web'],
            ['name' => 'dna matching', 'guard_name' => 'web'],
            ['name' => 'how to videos', 'guard_name' => 'web'],
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }

        $role = Role::create(['name' => 'free']);
		$role = Role::create(['name' => 'expired']);

        $role = Role::create(['name' => 'UTY']);
		$role = Role::create(['name' => 'UTM']);

        $role = Role::create(['name' => 'TTY']);
        $role = Role::create(['name' => 'TTM']);

        $role = Role::create(['name' => 'OTY']);
        $role = Role::create(['name' => 'OTM']);

        $role = Role::create(['name' => 'admin']);

        //Free Role
        $free = Role::where('name', 'free')->first();
        $role_id = $free->id;
        $free_permission = [
            'dashboard',
            'calendar',
            'files',
            'information',
            'sources',
            'people',
        ];
        foreach($free_permission as $link){
            $permission = Permission::where('name', $link)->first();
            if($permission !== null ) {
                $permission->roles()->detach($role_id);
                $permission->roles()->attach($role_id);
            }
        } 

        //Expired Role
        $expired = Role::where('name', 'expired')->first();
        $role_id = $expired->id;
        $expired_permissions = [
            'people',
            'family',
            'references',
            'trees',
        ];
        foreach($expired_permissions as $link){
            $permission = Permission::where('name', $link)->first();
            if($permission !== null ) {
                $permission->roles()->detach($role_id);
                $permission->roles()->attach($role_id);
            }
        }

        $roles = Role::whereNotIn('name', ['free', 'expired'])->get();
        $permissions = Permission::where([
            ['name','not like', '%information%'],
            ['name','not like', '%sources%'],
            ['name','not like', '%people%'],
        ])->get();
        foreach($roles as $role) {
            foreach($permissions as $permission){
                if($permission !== null ) {
                    $permission->roles()->detach($role->id);
                    $permission->roles()->attach($role->id);
                }
            }
        }
    }
}
