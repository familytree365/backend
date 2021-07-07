<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Builder\Param;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);
        if(!$user) {
            return response()->json([
                'message' => 'This action is unauthorized.',
            ],403);
        }

        // do this check ,only if you allow verified user to login
        //    if(! hash_equals((string) $request->id,(string) $user->getKey())){
        //        throw new AuthorizationException;
        //    }

        if (! hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false,
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User Already Verified!',
                'success' => false,
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'message' => 'Email verified successfully!',
            'success' => true,
        ]);
    }

    public function resendVerificatonEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'success' => false,
            ], 404);
        }
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Check your email',
            'success' => true,
        ]);
    }

}
