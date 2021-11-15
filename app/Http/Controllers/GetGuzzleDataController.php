<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetGuzzleDataController extends Controller
{
    public function guzzleGet()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://api.jikan.moe/v3/anime/1/characters_staff');
        $response = $request->getBody();
        $payload = json_decode($request->getBody()->getContents());

        dd($payload);
    }
}
