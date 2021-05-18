<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use PhpParser\Builder\Param;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

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
                'message' => 'User Allready Verified!',
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
        $user = User::where('email', $request->email)->firstOrFail();
        if (! $user) {
            return response()->json([
                'message' => 'Failed to send!',
                'success' => false,
            ]);
        }
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Check your email',
            'success' => true,
        ]);
    }
}
