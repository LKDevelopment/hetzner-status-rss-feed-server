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
        Tracking::track('get_trace_to_ip', $ip, get_user_agent());

        return response()->json(['traces' => $this->cacheOrTrace($ip)]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $ip
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCloudHost(Request $request, $ip)
    {
        $request['ip'] = $ip;
        $this->validate($request, [
            'ip' => ['required', 'ip', 'hetzner_ip'],
        ]);
        $lastHop = last(collect($this->cacheOrTrace($ip))->reject(function ($c) {
            return $c->cloud_id == null;
        })->toArray());
        Tracking::track('get_cloud_host_to_ip', $ip, get_user_agent());

        return response()->json($lastHop);
    }

    /**
     * @param $ip
     * @return mixed
     */
    protected function cacheOrTrace($ip)
    {
        return json_decode(Cache::remember('traceing_'.$ip, 60 * 24 * 7, function () use ($ip) {
            exec('mtr -j '.escapeshellarg($ip), $output);
            $hosts = [];
            $output = json_decode($output);
            foreach ($output->report->hubs as $index => $data) {
                if ($data->count == 1) {
                    continue;
                }
                $host = $data->host;

                $ip = gethostbyname($host);

                $cloud_id = null;
                if (str_contains($host, 'your-cloud.host')) {
                    $_host_parts = explode('.', $host);
                    $cloud_id = $_host_parts[0];
                }
                $hosts[] = ["ip" => $ip, 'host' => $host, 'cloud_id' => $cloud_id];
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
        $lastHop = collect($this->cacheOrTrace($ip))->reject(function ($item) {
            return $item->cloud_id == null;
        })->last();

        return response()->json($lastHop);
        Tracking::track('get_issues_to_ip', $ip, get_user_agent());
        if (str_contains($lastHop->host, 'your-cloud.host')) {
            $cloudHost = str_replace('.your-cloud.host', '', $lastHop->host);
            $response = Message::where('category', '=', 'cloud')->where('affected_en', 'LIKE', '%'.$cloudHost.'%')->where('created_at', '>', Carbon::now()->subDays(2)->startOfDay())->get();
        } else {
            $response = [];
        }

        return response()->json($response);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getIpToName(Request $request)
    {
        $data = $this->validate($request, ['hostname' => 'required']);

        return response()->json(Cache::remember('hostname_'.$data['hostname'], 60 * 24 * 2, function () use ($data) {
            return json_encode(['resp' => gethostbyname($data['hostname'])]);
        }));
    }
}