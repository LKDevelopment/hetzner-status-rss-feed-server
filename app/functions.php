<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 08.05.18
 * Time: 18:59
 */

if (! function_exists('get_user_agent')) {
    function get_user_agent()
    {
        return request()->hasHeader('App-Agent') ? request()->header('App-Agent') : request()->userAgent();
    }
}