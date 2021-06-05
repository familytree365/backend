<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ResetPasswordRequest;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class ForgotPasswordController extends Controller
{
    use UsesLandlordConnection;

    public function forgot(Request $request)
    {
        $credentials = request()->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json([
                'email' => 'Email not exits in record',
                'error' => '404',
                'error_msg' => 'Email not exits in record'],405);
        }
        $token = $this->generateToken();
        DB::connection($this->getConnectionName())->table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token, //change 60 to any length you want
            'created_at' => Carbon::now(),
        ]);
        $user->sendPasswordResetNotification($token);

        return response()->json(['msg' => 'Reset password link sent on your email id.']);
    }

    private function generateToken()
    {
        // This is set in the .env file
        $key = config('app.key');

        // Illuminate\Support\Str;
        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return hash_hmac('sha256', Str::random(40), $key);
    }

    public function reset(Request $request)
    {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);



        $tokenData = DB::connection($this->getConnectionName())->table('password_resets')
        ->where('token', $request->token)->where('email', $request->email)->first();

        if ($tokenData) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->password = bcrypt($request->password);
                $user->save(); //or $user->save();
                DB::connection($this->getConnectionName())->table('password_resets')->where('email', $user->email)->delete();
                return response()->json(['msg' => 'Password has been successfully changed.'], 200);
            } else {
                return response()->json(['error_msg' => 'User Not available.'],404);
            }
        } else {
            return response()->json(['error_msg' => 'Token not match for this email.'], 422);
        }
    }
}
