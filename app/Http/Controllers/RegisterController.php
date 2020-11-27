<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) {
    	$request->validate([
    		'name' => ['required'],
    		'email' => ['required', 'email', 'unique:users'],
    		'password' => ['required', 'min:8', 'confirmed']
    	]);

    	User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password)
    	]);
    }
}
