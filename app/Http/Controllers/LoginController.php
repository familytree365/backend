<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request) {
    	$request->validate([
    		"email" => ["required"],
    		"password" => ["required"]
    	]);

    	if(Auth::attempt($request->only(["email", "password"]))) {
    		return response()->json(auth()->user(), 200);
    	}

    	throw ValidationException::withMessage([
    		'email' => ['The provided credentials are incorrect.']
    	]);
    }

    public function logout(Request $request) {
    	Auth::logout();
    }
}
