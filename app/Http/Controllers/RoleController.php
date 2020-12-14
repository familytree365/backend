<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
    	return auth()->user()->getAllPermissions()->pluck('name');
    }
}
