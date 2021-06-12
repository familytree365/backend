<?php

namespace App\Http\Controllers;

use DB;
use Artisan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class LoginController extends Controller
{
    use UsesLandlordConnection;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        if($request->has('isSocialLogin') && $request->isSocialLogin == true) {
            $find = User::where('email', $request->email)->first();

            if($find) {
                Auth::loginUsingId($find->id);
                return response()->json(auth()->user(), 200);
            } else {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
        }
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $remember = $request->get("remember") ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {

        }
        if (Auth::attempt($request->only(['email', 'password']), $remember)) {
            return response()->json(auth()->user(), 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return response()->json(
            Socialite::driver($provider)
                ->stateless()
                ->redirect()
                ->getTargetUrl()
        );

         // return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            $output = ['data' => [], 'message' => 'Invalid credentials provided!', 'success' => false, 'error' => true];
            return view('callback', $output);
            // return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }
        $IfExists = User::where('email', $user->getEmail())->first();
        if ($IfExists) {
            Auth::loginUsingId($IfExists->id, $remember = true);
            $token = $IfExists->createToken('token-name')->plainTextToken;
            $output = ['access_token' => $token, 'data' => json_encode($IfExists), 'message' => 'Login Success!', 'success' => true, 'error' => false];
            return view('callback', $output);
        } else {
            try {
                DB::connection($this->getConnectionName())->beginTransaction();
                $userCreated = User::create(
                    [
                        'first_name' => $user->getName(),
                        'last_name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'email_verified_at' => now(),
                        'trial_ends_at' => now()->addDays(30),
                    ],
                );
                $userCreated->providers()->updateOrCreate(
                    [
                        'provider' => $provider,
                        'provider_id' => $user->getId(),
                    ],
                    [
                        'avatar' => $user->getAvatar(),
                    ]
                );
                $token = $userCreated->createToken('token-name')->plainTextToken;

                $this->updateProviderUser($userCreated);

                Auth::loginUsingId($userCreated->id, $remember = true);

                $output = ['access_token' => $token, 'data' => json_encode($userCreated), 'message' => 'Login Success!', 'success' => true, 'error' => false];

                DB::connection($this->getConnectionName())->commit();
                return view('callback', $output);

            } catch (Exception $e) {
                DB::connection($this->getConnectionName())->rollback();
            }
        }
        return response()->json($userCreated, 200, ['Access-Token' => $token]);
    }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'google'])) {
            return response()->json(['error' => 'Please login using facebook or google'], 422);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
    }

    /**
     * @param $user
     */
    public function updateProviderUser($user)
    {
        event(new Registered($user));
        $user_id = $user->id;
        $user = User::find($user_id);
        $user->assignRole('free');
        $random = $this->unique_random('companies', 'name', 5);
        $company_id = DB::connection($this->getConnectionName())->table('companies')->insertGetId([
            'name' => 'company' . $random,
            'status' => 1,
            'current_tenant' => 1,
        ]);

        DB::connection($this->getConnectionName())->table('user_company')->insert([
            'user_id' => $user_id,
            'company_id' => $company_id,
        ]);

        $tree_id = DB::connection($this->getConnectionName())->table('trees')->insertGetId([
            'company_id' => $company_id,
            'name' => 'tree' . $company_id,
            'description' => '',
            'current_tenant' => 1,
        ]);

        $tenant_id = DB::connection($this->getConnectionName())->table('tenants')->insertGetId([
            'name' => 'tenant' . $tree_id,
            'tree_id' => $tree_id,
            'database' => 'tenant' . $tree_id,
        ]);

        DB::statement('create database tenant' . $tree_id);

        Artisan::call('tenants:artisan "migrate --database=tenant --force"');
    }

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
        } while (!$unique);

        return $random;
    }
    public function providerLogin(Request $request, $provider) {
        $data = $request->all();
        return response()->json($data);
    }
}
