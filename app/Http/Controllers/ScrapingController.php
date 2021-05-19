<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ScrapingController extends Controller
{
    /**
     * @param Request $request
     * @return false|string
     */
    public function scrapOpenArch(Request $request)
    {
        $name = $request->get('name');
        $lang = $request->get('lang') ?? 'en';

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {

            return json_encode(['status' => 400, 'message' => $validator->getMessageBag()->getMessages()]);
        }

        $url = 'https://api.openarch.nl/1.0/records/search.json?name='.$name.'&lang='.$lang;

        $response = Http::get($url);

        if ($response->failed()) {

            return json_encode(['status' => 400, 'message' => 'Error the openarch server responded with error']);
        }

        $result = $response->json();

        return json_encode(['status' => 200, 'message' => 'Success', 'data' => $result]);
    }
}
