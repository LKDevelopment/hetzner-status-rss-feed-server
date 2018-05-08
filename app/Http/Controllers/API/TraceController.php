<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 07.05.18
 * Time: 10:28
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Model\Tracking;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class TraceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param $ip
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, $ip)
    {
        $request['ip'] = $ip;
        $this->validate($request, [
            'ip' => ['required', 'ip', 'hetzner_ip'],
        ]);
        Tracking::track('get_trace_to_ip', $ip);

        return response()->json($this->cacheOrTrace($ip));
    }

    /**
     * @param $ip
     * @return mixed
     */
    protected function cacheOrTrace($ip)
    {
        return json_decode(Cache::remember($ip, 60 * 24, function () use ($ip) {
            exec('traceroute '.escapeshellarg($ip), $output);
            $hosts = [];
            foreach ($output as $index => $line) {
                if ($index == 0) {
                    continue;
                }
                $line_parts = explode(' ', ltrim($line));
                if (! empty($line_parts) && $line_parts[2] != '*' && $line_parts[3] != '*') {
                    $ip = str_replace(['(', ')'], '', $line_parts[3]);
                    $host = $line_parts[2];
                    if ($ip == $host) {
                        $host = gethostbyaddr($ip);
                    }
                    $hosts[] = ["ip" => $ip, 'host' => $host];
                }
            }

            return json_encode($hosts);
        }));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $ip
     * @return \Illuminate\Http\JsonResponse
     */
    public function issues(Request $request, $ip)
    {
        $request['ip'] = $ip;
        $this->validate($request, [
            'ip' => ['required', 'ip', 'hetzner_ip'],
        ]);
        $lastHop = last($this->cacheOrTrace($ip));
        Tracking::track('get_issues_to_ip', $ip);
        if (str_contains($lastHop->host, 'your-cloud.host')) {
            $cloudHost = str_replace('.your-cloud.host', '', $lastHop->host);
            $response = Message::where('category', '=', 'cloud')->where('title_en', 'LIKE', '%'.$cloudHost.'%')->where('created_at', '>', Carbon::now()->subDays(2)->startOfDay())->get();
        } else {
            $response = [];
        }

        return response()->json($response);
    }
}