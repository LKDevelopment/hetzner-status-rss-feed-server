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
use Cache;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TraceController extends Controller
{

    public function get(Request $request, $ip)
    {
        $request['ip'] = $ip;
        $this->validate($request, [
            'ip' => ['required', 'ip', 'hetzner_ip'],
        ]);
        if (Cache::has($ip)) {
            echo "Cache";
            return response()->json(Cache::get($ip));
        } else {
            exec('traceroute ' . escapeshellarg($ip), $output);
            $hosts = [];
            foreach ($output as $index => $line) {
                if ($index == 0) continue;
                $line_parts = explode(' ', ltrim($line));
                if (!empty($line_parts) && $line_parts[2] != '*' && $line_parts[3] != '*') {
                    $ip = str_replace(['(', ')'], '', $line_parts[3]);
                    $host = $line_parts[2];
                    if ($ip == $host) {
                        $host = gethostbyaddr($ip);
                    }
                    $hosts[] = [$ip => $host];
                }
            }
            Cache::put($ip, $hosts, now()->addHour());

            return response()->json($hosts);

        }
    }
}