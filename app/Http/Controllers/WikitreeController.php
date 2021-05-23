<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WikitreeController extends Controller
{
    public function getAuthCode(Request $request)
    {
        $authCode = $request->authcode;
        $endpoint = "https://api.wikitree.com/api.php";
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', $endpoint, ['query' => [
            'authcode' => $authCode, 
            'action' => 'clientLogin',
            'format' => 'json'
        ]]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $userInfo = json_decode($response->getBody(), true);

        return response()->json($userInfo);
    }
}
