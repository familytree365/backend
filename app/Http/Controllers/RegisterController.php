<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class RegisterController extends Controller
{
    use UsesLandlordConnection;

    /**
     * @param Request $request
     */
    public function register(Request $request)
    {
        $result = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:landlord.users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'conditions_terms' => ['required', 'accepted'],
        ]);

        DB::connection($this->getConnectionName())->beginTransaction();
        try {
            // $user_id = DB::connection($this->getConnectionName())->table('users')->insertGetId([
            // 	'first_name' => $request->first_name,
            // 	'last_name' => $request->last_name,
            // 	'email' => $request->email,
            // 	'password' => bcrypt($request->password),
            // ]);
            // $user = User::create([
            // 	'first_name' => $request->first_name,
            // 	'last_name' => $request->last_name,
            // 	'email' => $request->email,
            // 	'password' => bcrypt($request->password)
            // ]);

            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            // moved that down to make sure user receives verification notification after he is really registered
            // event(new Registered($user));

            /*
            $user_id = $user->id;
            $user = User::find($user_id);
            */
            $role = Role::where("name","=","free")->first();

            if($role == null) {
                $role = Role::create(['name' => 'free']);
            }
            $user->assignRole([$role->id]);

            // $user->sendEmailVerificationNotification();

            $random = $this->unique_random('companies', 'name', 5);

            $company_id = DB::connection($this->getConnectionName())->table('companies')->insertGetId([
                'name' => 'company'.$random,
                'status' => 1,
                'current_tenant' => 1,
            ]);

            DB::connection($this->getConnectionName())->table('user_company')->insert([
                'user_id' => $user->id,
                'company_id' => $company_id,
            ]);

            $tree_id = DB::connection($this->getConnectionName())->table('trees')->insertGetId([
                'company_id' => $company_id,
                'name' => 'tree'.$company_id,
                'description' => '',
                'current_tenant' => 1,
            ]);

            $tenant_db = 'tenant'.$tree_id;

            $tenant_id = DB::connection($this->getConnectionName())->table('tenants')->insertGetId([
                'name' => $tenant_db,
                'tree_id' => $tree_id,
                'database' => $tenant_db,
            ]);

            // Config::set('database.connections.tenant.database', $tenant_db);

            DB::connection($this->getConnectionName())->commit();

        } catch (Exception $e) {
            error_log('failed to register');
            error_log($e->getMessage());
            DB::connection($this->getConnectionName())->rollback();

        }

        DB::connection($this->getConnectionName())->statement('CREATE DATABASE ' . $tenant_db);
        Artisan::call('tenants:artisan "migrate --database=tenant --force"');
        event(new Registered($user));
      }

    /**
     * @param $table
     * @param $col
     * @param int $chars
     * @return string
     */
    public function unique_random($table, $col, $chars = 16)
    {
        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do {
            // Generate random string of characters
            $random = Str::random($chars);

            // Check if it's already testing
            // If so, don't query the database again
            if (in_array($random, $tested)) {
                continue;
            }

            // Check if it is unique in the database
            $count = DB::connection($this->getConnectionName())->table('companies')->where($col, '=', $random)->count();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if ($count == 0) {
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters
        } while (! $unique);

        return $random;
    }
}
