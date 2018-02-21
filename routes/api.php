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
            'general.fault_report' => ['de' => 'Allgemeine Störungen'],
            'general.fault_report.update' => ['de' => 'Allgemeine Störungen Updates'],
            'general.maintaince_work' => ['de' => 'Allgemeine Wartungsarbeiten'],
            'general.maintaince_work.update' => ['de' => 'Allgemeine Wartungsarbeiten Updates'],
            'general.miscellaneous' => ['de' => 'Allgemein Sonstiges'],
            'general.miscellaneous.update' => ['de' => 'Allgemeine Sonstiges Updates'],
        ],
        'basic_infrastructur' => [
            'basic_infrastructur.fault_report' => ['de' => 'Basis Infrastruktur Störungen'],
            'basic_infrastructur.fault_report.update' => ['de' => 'Basis Infrastruktur Störungen Updates'],
            'basic_infrastructur.maintaince_work' => ['de' => 'Basis Infrastruktur Wartungsarbeiten'],
            'basic_infrastructur.maintaince_work.update' => ['de' => 'Basis Infrastruktur Wartungsarbeiten Updates'],
            'basic_infrastructur.miscellaneous' => ['de' => 'Basis Infrastruktur Sonstiges'],
            'basic_infrastructur.miscellaneous.update' => ['de' => 'Basis Infrastruktur Sonstiges Updates'],
        ],
        'advanced_infrastructur' => [
            'advanced_infrastructur.fault_report' => ['de' => 'Erweiterte Infrastruktur Störungen'],
            'advanced_infrastructur.fault_report.update' => ['de' => 'Erweiterte Infrastruktur Störungen Updates'],
            'advanced_infrastructur.maintaince_work' => ['de' => 'Erweiterte Infrastruktur Wartungsarbeiten'],
            'advanced_infrastructur.maintaince_work.update' => ['de' => 'Erweiterte Infrastruktur Wartungsarbeiten Updates'],
            'advanced_infrastructur.miscellaneous' => ['de' => 'Erweiterte Infrastruktur Sonstiges'],
            'advanced_infrastructur.miscellaneous.update' => ['de' => 'Erweiterte Infrastruktur Sonstiges Updates'],
        ],
        'network' => [
            'network.fault_report' => ['de' => 'Netzwerk Störungen'],
            'network.fault_report.update' => ['de' => 'Netzwerk Störungen Updates'],
            'network.maintaince_work' => ['de' => 'Netzwerk Wartungsarbeiten'],
            'network.maintaince_work.update' => ['de' => 'Netzwerk Wartungsarbeiten Updates'],
            'network.miscellaneous' => ['de' => 'Netzwerk Sonstiges'],
            'network.miscellaneous.update' => ['de' => 'Netzwerk Sonstiges Updates'],
        ],
        'webhosting_and_managed_server' => [
            'webhosting_and_managed_server.fault_report' => ['de' => 'Webhosting & Managed Server Störungen'],
            'webhosting_and_managed_server.fault_report.update' => ['de' => 'Webhosting & Managed Server Störungen Updates'],
            'webhosting_and_managed_server.maintaince_work' => ['de' => 'Webhosting & Managed Server Wartungsarbeiten'],
            'webhosting_and_managed_server.maintaince_work.update' => ['de' => 'Webhosting & Managed Server Wartungsarbeiten Updates'],
            'webhosting_and_managed_server.miscellaneous' => ['de' => 'Webhosting & Managed Server Sonstiges'],
            'webhosting_and_managed_server.miscellaneous.update' => ['de' => 'Webhosting & Managed Server Sonstiges Updates'],
        ],
        'domain_registration_robot' => [
            'domain_registration_robot.fault_report' => ['de' => 'Domain Registration Robot Störungen'],
            'domain_registration_robot.fault_report.update' => ['de' => 'Domain Registration Robot Störungen Updates'],
            'domain_registration_robot.maintaince_work' => ['de' => 'Domain Registration Robot Wartungsarbeiten'],
            'domain_registration_robot.maintaince_work.update' => ['de' => 'Domain Registration Robot Wartungsarbeiten Updates'],
            'domain_registration_robot.miscellaneous' => ['de' => 'Domain Registration Robot Sonstiges'],
            'domain_registration_robot.miscellaneous.update' => ['de' => 'Domain Registration Robot Sonstiges Updates'],
        ],
        'v_servers' => [
            'v_servers.fault_report' => ['de' => 'vServer Störungen'],
            'v_servers.fault_report.update' => ['de' => 'vServer Störungen Updates'],
            'v_servers.maintaince_work' => ['de' => 'vServer Wartungsarbeiten'],
            'v_servers.maintaince_work.update' => ['de' => 'vServer Wartungsarbeiten Updates'],
            'v_servers.miscellaneous' => ['de' => 'vServer Sonstiges'],
            'v_servers.miscellaneous.update' => ['de' => 'vServer Sonstiges Updates'],
        ],
        'cloud' => [
            'cloud.fault_report' => ['de' => 'Cloud Störungen'],
            'cloud.fault_report.update' => ['de' => 'Cloud Störungen Updates'],
            'cloud.maintaince_work' => ['de' => 'Cloud Wartungsarbeiten'],
            'cloud.maintaince_work.update' => ['de' => 'Cloud Wartungsarbeiten Updates'],
            'cloud.miscellaneous' => ['de' => 'Cloud Sonstiges'],
            'cloud.miscellaneous.update' => ['de' => 'Cloud Sonstiges Updates'],
        ],
    ]);
});