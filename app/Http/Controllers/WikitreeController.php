<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WikitreeController extends Controller
{
    private $wikitreeApi;

    public function __construct()
    {
        $this->wikitreeApi = config('services.wikitree.api');
    }

    public function getAuthCode(Request $request)
    {
        $authCode = $request->authcode;
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', $this->wikitreeApi, ['query' => [
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
