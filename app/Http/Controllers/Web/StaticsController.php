<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 *
 */
class StaticsController extends Controller
{
    /**
     * StaticsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function getTracingCache()
    {
        $caches = collect(\Cache::getRedis()->keys('laravel_cache:traceing_*'))->map(function ($val) {
            return str_replace('laravel_cache:traceing_', '', $val);
        });

        return response()->view('web.statics.traching_cache', compact('caches'));
    }
}
