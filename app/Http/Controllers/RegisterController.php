<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request) {
    	$request->validate([
    		'first_name' => ['required'],
            'last_name' => ['required'],
    		'email' => ['required', 'email', 'unique:users'],
    		'password' => ['required', 'min:8', 'confirmed']
    	]);

    	User::create([
    		'first_name' => $request->first_name,
            'last_name' => $request->last_name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password)
    	]);
    }
}
