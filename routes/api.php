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
            'label' => ['de' => 'Allgemein'],
            'general.fault_report' => ['de' => 'Störungen'],
            'general.fault_report.update' => ['de' => 'Störungen Updates'],
            'general.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'general.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'general.miscellaneous' => ['de' => 'Sonstiges'],
            'general.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
        'basic_infrastructur' => [
            'label' => ['de' => 'Basis Infrastruktur'],
            'basic_infrastructur.fault_report' => ['de' => 'Störungen'],
            'basic_infrastructur.fault_report.update' => ['de' => 'Störungen Updates'],
            'basic_infrastructur.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'basic_infrastructur.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'basic_infrastructur.miscellaneous' => ['de' => 'Sonstiges'],
            'basic_infrastructur.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
        'advanced_infrastructur' => [
            'label' => ['de' => 'Erweiterte Infrastruktur'],
            'advanced_infrastructur.fault_report' => ['de' => 'Störungen'],
            'advanced_infrastructur.fault_report.update' => ['de' => 'Störungen Updates'],
            'advanced_infrastructur.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'advanced_infrastructur.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'advanced_infrastructur.miscellaneous' => ['de' => 'Sonstiges'],
            'advanced_infrastructur.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
        'network' => [
            'label' => ['de' => 'Netzwerk'],
            'network.fault_report' => ['de' => 'Störungen'],
            'network.fault_report.update' => ['de' => 'Störungen Updates'],
            'network.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'network.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'network.miscellaneous' => ['de' => 'Sonstiges'],
            'network.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
        'webhosting_and_managed_server' => [
            'label' => ['de' => 'Webhosting & Managed Server'],
            'webhosting_and_managed_server.fault_report' => ['de' => 'Störungen'],
            'webhosting_and_managed_server.fault_report.update' => ['de' => ' Störungen Updates'],
            'webhosting_and_managed_server.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'webhosting_and_managed_server.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'webhosting_and_managed_server.miscellaneous' => ['de' => 'Sonstiges'],
            'webhosting_and_managed_server.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
        'domain_registration_robot' => [
            'label' => ['de' => 'Domain Registration Robot'],
            'domain_registration_robot.fault_report' => ['de' => 'Störungen'],
            'domain_registration_robot.fault_report.update' => ['de' => 'Störungen Updates'],
            'domain_registration_robot.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'domain_registration_robot.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'domain_registration_robot.miscellaneous' => ['de' => 'Sonstiges'],
            'domain_registration_robot.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
        'v_servers' => [
            'label' => ['de' => 'vServer'],
            'v_servers.fault_report' => ['de' => 'Störungen'],
            'v_servers.fault_report.update' => ['de' => 'Störungen Updates'],
            'v_servers.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'v_servers.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'v_servers.miscellaneous' => ['de' => 'Sonstiges'],
            'v_servers.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
        'cloud' => [
            'label' => ['de' => 'Cloud'],
            'cloud.fault_report' => ['de' => 'Störungen'],
            'cloud.fault_report.update' => ['de' => 'Störungen Updates'],
            'cloud.maintaince_work' => ['de' => 'Wartungsarbeiten'],
            'cloud.maintaince_work.update' => ['de' => 'Wartungsarbeiten Updates'],
            'cloud.miscellaneous' => ['de' => 'Sonstiges'],
            'cloud.miscellaneous.update' => ['de' => 'Sonstiges Updates'],
        ],
    ]);
});