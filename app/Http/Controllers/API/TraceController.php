<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 07.05.18
 * Time: 10:28
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TraceController extends Controller
{

    public function get(Request $request, $ip)
    {
        $request['ip'] = $ip;
        $this->validate($request, [
            'ip' => 'required|ip',
        ]);
        $client = new Client();
        $response = $client->get("https://get.geojs.io/v1/ip/geo/" . $ip . ".json");

        $response = \GuzzleHttp\json_decode((string)$response->getBody());
        var_dump($response);
        if (str_contains($response->organization, 'Hetzner')) {
            echo "OK!";
        } else {
            echo "NOT OK!";
        }
    }
}