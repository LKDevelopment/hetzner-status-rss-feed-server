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
        [
            'label' => ['de' => 'Allgemein'],
            'tags' => [
                [
                    'key' => 'general.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'general.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'general.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'general.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'general.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'general.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
        [
            'label' => ['de' => 'Basis Infrastruktur'],
            'tags' => [
                [
                    'key' => 'basic_infrastructur.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'basic_infrastructur.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'basic_infrastructur.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'basic_infrastructur.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'basic_infrastructur.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'basic_infrastructur.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
        [
            'label' => ['de' => 'Erweiterte Infrastruktur'],
            'tags' => [
                [
                    'key' => 'advanced_infrastructur.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'advanced_infrastructur.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'advanced_infrastructur.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'advanced_infrastructur.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'advanced_infrastructur.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'advanced_infrastructur.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
        [
            'label' => ['de' => 'Netzwerk'],
            'tags' => [
                [
                    'key' => 'network.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'network.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'network.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'network.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'network.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'network.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
        [
            'label' => ['de' => 'Webhosting & Managed Server'],
            'tags' => [
                [
                    'key' => 'webhosting_and_managed_server.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'webhosting_and_managed_server.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'webhosting_and_managed_server.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'webhosting_and_managed_server.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'webhosting_and_managed_server.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'webhosting_and_managed_server.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
        [
            'label' => ['de' => 'Domain Registration Robot'],
            'tags' => [
                [
                    'key' => 'domain_registration_robot.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'domain_registration_robot.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'domain_registration_robot.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'domain_registration_robot.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'domain_registration_robot.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'domain_registration_robot.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
        [
            'label' => ['de' => 'vServer'],
            'tags' => [
                [
                    'key' => 'v_servers.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'v_servers.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'v_servers.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'v_servers.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'v_servers.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'v_servers.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
        [
            'label' => ['de' => 'Cloud'],
            'tags' => [
                [
                    'key' => 'cloud.fault_report',
                    'label' => ['de' => 'Störungen'],
                ],
                [
                    'key' => 'cloud.fault_report.update',
                    'label' => ['de' => 'Störungen Updates'],
                ],
                [
                    'key' => 'cloud.maintaince_work',
                    'label' => ['de' => 'Wartungsarbeiten'],
                ],
                [
                    'key' => 'cloud.maintaince_work.updates',
                    'label' => ['de' => 'Wartungsarbeiten Updates'],
                ],
                [
                    'key' => 'cloud.miscellaneous',
                    'label' => ['de' => 'Sonstiges'],
                ],
                [
                    'key' => 'cloud.miscellaneous.updates',
                    'label' => ['de' => 'Sonstiges Updates'],
                ],
            ],
        ],
    ]);
});