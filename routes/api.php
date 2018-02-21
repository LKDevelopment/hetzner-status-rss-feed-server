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

Route::get('v2/messages', function () {
    return response()->json(\App\Model\Message::onlyParents()->get());
});
Route::get('v2/tags', function () {
    return response()->json([
        'general' => [
            'general.fault_report' => 'update',
            'general.fault_report.update' => 'update',
            'general.maintaince_work' => 'update',
            'general.maintaince_work.update' => 'update',
            'general.miscellaneous' => 'update',
            'general.miscellaneous.update' => 'update',
        ],
        'basic_infrastructur' => [
            'basic_infrastructur.fault_report' => 'update',
            'basic_infrastructur.fault_report.update' => 'update',
            'basic_infrastructur.maintaince_work' => 'update',
            'basic_infrastructur.maintaince_work.update' => 'update',
            'basic_infrastructur.miscellaneous' => 'update',
            'basic_infrastructur.miscellaneous.update' => 'update',
        ],
        'advanced_infrastructur' => [
            'advanced_infrastructur.fault_report' => 'update',
            'advanced_infrastructur.fault_report.update' => 'update',
            'advanced_infrastructur.maintaince_work' => 'update',
            'advanced_infrastructur.maintaince_work.update' => 'update',
            'advanced_infrastructur.miscellaneous' => 'update',
            'advanced_infrastructur.miscellaneous.update' => 'update',
        ],
        'network' => [
            'network.fault_report' => 'update',
            'network.fault_report.update' => 'update',
            'network.maintaince_work' => 'update',
            'network.maintaince_work.update' => 'update',
            'network.miscellaneous' => 'update',
            'network.miscellaneous.update' => 'update',
        ],
        'webhosting_and_managed_server' => [
            'webhosting_and_managed_server.fault_report' => 'update',
            'webhosting_and_managed_server.fault_report.update' => 'update',
            'webhosting_and_managed_server.maintaince_work' => 'update',
            'webhosting_and_managed_server.maintaince_work.update' => 'update',
            'webhosting_and_managed_server.miscellaneous' => 'update',
            'webhosting_and_managed_server.miscellaneous.update' => 'update',
        ],
        'domain_registration_robot' => [
            'domain_registration_robot.fault_report' => 'update',
            'domain_registration_robot.fault_report.update' => 'update',
            'domain_registration_robot.maintaince_work' => 'update',
            'domain_registration_robot.maintaince_work.update' => 'update',
            'domain_registration_robot.miscellaneous' => 'update',
            'domain_registration_robot.miscellaneous.update' => 'update',
        ],
        'v_servers' => [
            'v_servers.fault_report' => 'update',
            'v_servers.fault_report.update' => 'update',
            'v_servers.maintaince_work' => 'update',
            'v_servers.maintaince_work.update' => 'update',
            'v_servers.miscellaneous' => 'update',
            'v_servers.miscellaneous.update' => 'update',
        ],
        'cloud' => [
            'cloud.fault_report' => 'update',
            'cloud.fault_report.update' => 'update',
            'cloud.maintaince_work' => 'update',
            'cloud.maintaince_work.update' => 'update',
            'cloud.miscellaneous' => 'update',
            'cloud.miscellaneous.update' => 'update',
        ],
    ]);
});