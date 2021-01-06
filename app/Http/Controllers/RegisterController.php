<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use App\Models\User;
use App\Models\Tree;
use DB;
use Artisan;

class RegisterController extends Controller
{
    use UsesLandlordConnection;

    public function register(Request $request) {
    	$request->validate([
    		'first_name' => ['required'],
            'last_name' => ['required'],
    		'email' => ['required', 'email', 'unique:landlord.users'],
    		'password' => ['required', 'min:8', 'confirmed']
    	]);

        $user_id = DB::connection($this->getConnectionName())->table('users')->insertGetId([ 
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user = User::find($user_id);
        $user->assignRole('free');

        $company_id = DB::connection($this->getConnectionName())->table('companies')->insertGetId([
            'name' => 'company' . $user_id,
            'status' => 1,
            'current_tenant' => 1
        ]);

        DB::connection($this->getConnectionName())->table('user_company')->insert([
            'user_id' => $user_id,
            'company_id' => $company_id 
        ]);

        $tree_id = DB::connection($this->getConnectionName())->table('trees')->insertGetId([
            'company_id' => $company_id,
            'name' => 'tree' . $company_id,
            'description' => '',
            'current_tenant' => 1
        ]);

        $tenant_id = DB::connection($this->getConnectionName())->table('tenants')->insertGetId([
            'name' => 'tenant'.$tree_id,
            'tree_id' => $tree_id,
            'database' => 'tenant'.$tree_id
        ]);

        DB::statement('create database tenant'.$tree_id);

        Artisan::call('tenants:artisan "migrate --database=tenant --force"');
    }
}
