<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WikitreeController extends Controller
{
    public function getAuthCode(Request $request)
    {
        $authCode = $request->authcode;

        return response()->json($authCode);
    }
}
