<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('hetzner-status/{language?}', function ($language = 'de') {
    return response()->json(\App\StatusMeldung::onlyParents()->language($language)->get());
});

Route::get('v1/messages', function () {
    return response()->json(\App\Model\Message::onlyParents()->get());
});
Route::get('v1/tags', function () {
    return response()->json([
        'general' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
        'basic_infrastructur' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
        'advanced_infrastructur' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
        'network' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
        'webhosting_and_managed_server' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
        'domain_registration_robot' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
        'v_servers' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
        'cloud' => [
            'fault_report' => 'update',
            'maintaince_work' => 'update',
            'miscellaneous' => 'update',
        ],
    ]);
});