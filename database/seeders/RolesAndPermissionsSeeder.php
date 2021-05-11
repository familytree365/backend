<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use DB;
use Spatie\Multitenancy\Models\Tenant;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = Tenant::get();
        foreach($tenants as $tenant) {
            DB::statement("DROP DATABASE $tenant->name");
        }

         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

		$permissions = [
            ['name' => 'dashboard menu', 'guard_name' => 'web'],

            ['name' => 'calendar menu', 'guard_name' => 'web'],

            ['name' => 'files menu', 'guard_name' => 'web'],

            //Company menu permission
            ['name' => 'company menu', 'guard_name' => 'web'],
            ['name' => 'company index', 'guard_name' => 'web'],
            ['name' => 'company create', 'guard_name' => 'web'],
            ['name' => 'company edit', 'guard_name' => 'web'],
            ['name' => 'company delete', 'guard_name' => 'web'],

            //Information menu permission
            ['name' => 'information menu', 'guard_name' => 'web'],
            ['name' => 'objects index', 'guard_name' => 'web'],
            ['name' => 'objects create', 'guard_name' => 'web'],
            ['name' => 'objects edit', 'guard_name' => 'web'],
            ['name' => 'objects delete', 'guard_name' => 'web'],
            ['name' => 'addresses index', 'guard_name' => 'web'],
            ['name' => 'addresses create', 'guard_name' => 'web'],
            ['name' => 'addresses edit', 'guard_name' => 'web'],
            ['name' => 'addresses delete', 'guard_name' => 'web'],
            ['name' => 'chan index', 'guard_name' => 'web'],
            ['name' => 'chan create', 'guard_name' => 'web'],
            ['name' => 'chan edit', 'guard_name' => 'web'],
            ['name' => 'chan delete', 'guard_name' => 'web'],
            ['name' => 'refn index', 'guard_name' => 'web'],
            ['name' => 'refn create', 'guard_name' => 'web'],
            ['name' => 'refn edit', 'guard_name' => 'web'],
            ['name' => 'refn delete', 'guard_name' => 'web'],
            ['name' => 'subm index', 'guard_name' => 'web'],
            ['name' => 'subm create', 'guard_name' => 'web'],
            ['name' => 'subm edit', 'guard_name' => 'web'],
            ['name' => 'subm delete', 'guard_name' => 'web'],
            ['name' => 'subn index', 'guard_name' => 'web'],
            ['name' => 'subn create', 'guard_name' => 'web'],
            ['name' => 'subn edit', 'guard_name' => 'web'],
            ['name' => 'subn delete', 'guard_name' => 'web'],

            //source permission
            ['name' => 'sources menu', 'guard_name' => 'web'],
            ['name' => 'repositories index', 'guard_name' => 'web'],
            ['name' => 'repositories create', 'guard_name' => 'web'],
            ['name' => 'repositories edit', 'guard_name' => 'web'],
            ['name' => 'repositories delete', 'guard_name' => 'web'],
            ['name' => 'sources index', 'guard_name' => 'web'],
            ['name' => 'sources create', 'guard_name' => 'web'],
            ['name' => 'sources edit', 'guard_name' => 'web'],
            ['name' => 'sources delete', 'guard_name' => 'web'],
            ['name' => 'source data index', 'guard_name' => 'web'],
            ['name' => 'source data create', 'guard_name' => 'web'],
            ['name' => 'source data edit', 'guard_name' => 'web'],
            ['name' => 'source data delete', 'guard_name' => 'web'],
            ['name' => 'source data events index', 'guard_name' => 'web'],
            ['name' => 'source data events create', 'guard_name' => 'web'],
            ['name' => 'source data events edit', 'guard_name' => 'web'],
            ['name' => 'source data events delete', 'guard_name' => 'web'],
            ['name' => 'source ref events index', 'guard_name' => 'web'],
            ['name' => 'source ref events create', 'guard_name' => 'web'],
            ['name' => 'source ref events edit', 'guard_name' => 'web'],
            ['name' => 'source ref events delete', 'guard_name' => 'web'],

            //people permission
            ['name' => 'people menu', 'guard_name' => 'web'],
            ['name' => 'people index', 'guard_name' => 'web'],
            ['name' => 'people create', 'guard_name' => 'web'],
            ['name' => 'people edit', 'guard_name' => 'web'],
            ['name' => 'people delete', 'guard_name' => 'web'],
            ['name' => 'person aliases index', 'guard_name' => 'web'],
            ['name' => 'person aliases create', 'guard_name' => 'web'],
            ['name' => 'person aliases edit', 'guard_name' => 'web'],
            ['name' => 'person aliases delete', 'guard_name' => 'web'],
            ['name' => 'person anci index', 'guard_name' => 'web'],
            ['name' => 'person anci create', 'guard_name' => 'web'],
            ['name' => 'person anci edit', 'guard_name' => 'web'],
            ['name' => 'person anci delete', 'guard_name' => 'web'],
            ['name' => 'person association index', 'guard_name' => 'web'],
            ['name' => 'person association create', 'guard_name' => 'web'],
            ['name' => 'person association edit', 'guard_name' => 'web'],
            ['name' => 'person association delete', 'guard_name' => 'web'],
            ['name' => 'person events index', 'guard_name' => 'web'],
            ['name' => 'person events create', 'guard_name' => 'web'],
            ['name' => 'person events edit', 'guard_name' => 'web'],
            ['name' => 'person events delete', 'guard_name' => 'web'],
            ['name' => 'person lds index', 'guard_name' => 'web'],
            ['name' => 'person lds create', 'guard_name' => 'web'],
            ['name' => 'person lds edit', 'guard_name' => 'web'],
            ['name' => 'person lds delete', 'guard_name' => 'web'],
            ['name' => 'person subm index', 'guard_name' => 'web'],
            ['name' => 'person subm create', 'guard_name' => 'web'],
            ['name' => 'person subm edit', 'guard_name' => 'web'],
            ['name' => 'person subm delete', 'guard_name' => 'web'],

            //Family permission
            ['name' => 'family menu', 'guard_name' => 'web'],
            ['name' => 'families index', 'guard_name' => 'web'],
            ['name' => 'families create', 'guard_name' => 'web'],
            ['name' => 'families edit', 'guard_name' => 'web'],
            ['name' => 'families delete', 'guard_name' => 'web'],
            ['name' => 'family events index', 'guard_name' => 'web'],
            ['name' => 'family events create', 'guard_name' => 'web'],
            ['name' => 'family events edit', 'guard_name' => 'web'],
            ['name' => 'family events delete', 'guard_name' => 'web'],
            ['name' => 'family slugs index', 'guard_name' => 'web'],
            ['name' => 'family slugs create', 'guard_name' => 'web'],
            ['name' => 'family slugs edit', 'guard_name' => 'web'],
            ['name' => 'family slugs delete', 'guard_name' => 'web'],

            //References permission
            ['name' => 'references menu', 'guard_name' => 'web'],
            ['name' => 'citations index', 'guard_name' => 'web'],
            ['name' => 'citations create', 'guard_name' => 'web'],
            ['name' => 'citations edit', 'guard_name' => 'web'],
            ['name' => 'citations delete', 'guard_name' => 'web'],
            ['name' => 'notes index', 'guard_name' => 'web'],
            ['name' => 'notes create', 'guard_name' => 'web'],
            ['name' => 'notes edit', 'guard_name' => 'web'],
            ['name' => 'notes delete', 'guard_name' => 'web'],
            ['name' => 'places index', 'guard_name' => 'web'],
            ['name' => 'places create', 'guard_name' => 'web'],
            ['name' => 'places edit', 'guard_name' => 'web'],
            ['name' => 'places delete', 'guard_name' => 'web'],
            ['name' => 'authors index', 'guard_name' => 'web'],
            ['name' => 'authors create', 'guard_name' => 'web'],
            ['name' => 'authors edit', 'guard_name' => 'web'],
            ['name' => 'authors delete', 'guard_name' => 'web'],
            ['name' => 'publications index', 'guard_name' => 'web'],
            ['name' => 'publications create', 'guard_name' => 'web'],
            ['name' => 'publications edit', 'guard_name' => 'web'],
            ['name' => 'publications delete', 'guard_name' => 'web'],

            //Tree permission
            ['name' => 'trees menu', 'guard_name' => 'web'],
            ['name' => 'trees index', 'guard_name' => 'web'],
            ['name' => 'trees create', 'guard_name' => 'web'],
            ['name' => 'trees edit', 'guard_name' => 'web'],
            ['name' => 'trees delete', 'guard_name' => 'web'],
            ['name' => 'trees show index', 'guard_name' => 'web'],
            ['name' => 'trees show create', 'guard_name' => 'web'],
            ['name' => 'trees show edit', 'guard_name' => 'web'],
            ['name' => 'trees show delete', 'guard_name' => 'web'],
            ['name' => 'pedigree index', 'guard_name' => 'web'],
            ['name' => 'pedigree create', 'guard_name' => 'web'],
            ['name' => 'pedigree edit', 'guard_name' => 'web'],
            ['name' => 'pedigree delete', 'guard_name' => 'web'],

            //Forum permission
            ['name' => 'forum menu', 'guard_name' => 'web'],
            ['name' => 'subjects index', 'guard_name' => 'web'],
            ['name' => 'subjects create', 'guard_name' => 'web'],
            ['name' => 'subjects edit', 'guard_name' => 'web'],
            ['name' => 'subjects delete', 'guard_name' => 'web'],
            ['name' => 'categories index', 'guard_name' => 'web'],
            ['name' => 'categories create', 'guard_name' => 'web'],
            ['name' => 'categories edit', 'guard_name' => 'web'],
            ['name' => 'categories delete', 'guard_name' => 'web'],

            ['name' => 'gedcom import menu', 'guard_name' => 'web'],
            ['name' => 'subscription menu', 'guard_name' => 'web'],
            ['name' => 'dna upload menu', 'guard_name' => 'web'],
            ['name' => 'dna matching menu', 'guard_name' => 'web'],
            ['name' => 'how to videos menu', 'guard_name' => 'web'],
            ['name' => 'roles menu', 'guard_name' => 'web'],
            ['name' => 'permissions menu', 'guard_name' => 'web'],
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
        $role->givePermissionTo(Permission::all());

/**
        //Free Role
        $free = Role::where('name', 'free')->first();
        $role_id = $free->id;
        $free_permission = [
            'dashboard menu',
            'subscription menu',
            'gedcom import menu'
        ];

        foreach($free_permission as $link){
            $permission = Permission::where('name', $link)->first();
            if($permission !== null ) {
                $permission->roles()->detach($role_id);
                $permission->roles()->attach($role_id);
            }
        }
**/
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

        $roles = Role::whereNotIn('name', ['expired'])->get();
        $permissions = Permission::where([
            ['name','not like', '%information%'],
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
