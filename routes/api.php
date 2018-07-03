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
    \App\Model\Tracking::track('old_api', $language, get_user_agent());

    return response()->json(\App\StatusMeldung::onlyParents()->language($language)->limit(request('limit', 20))->get());
});

Route::get('v2/messages', function () {
    \App\Model\Tracking::track('api_v2', '', get_user_agent());

    return response()->json(\App\Model\Message::onlyParents()->limit(request('limit', 20))->get());
});

Route::get('metrics', function () {
    return response()->json(DB::table('trackings')->select('type', 'user_agent', DB::raw('COUNT(*) as count'))->groupBy('type', 'user_agent')->get()->groupBy('type'));
});
Route::post('domain', 'API\TraceController@getIpToName');
Route::group(['prefix' => 'traceing/{ip}'], function () {
    Route::get('/', 'API\TraceController@get');
    Route::get('/host', 'API\TraceController@getCloudHost');
    Route::get('/issues', 'API\TraceController@issues');
});
Route::get('bot/webhook/telegram', "Botman\WebhookController@telegram");
Route::post('bot/webhook/telegram', "Botman\WebhookController@telegram");
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

Route::group(['prefix' => 'device'], function () {
    Route::post('create', 'Api\DeviceTrackingController@create_device');
    Route::group(['prefix' => '{device}'], function () {
        Route::put('/', 'Api\DeviceTrackingController@update_device');
        Route::get('feature_flags', 'Api\DeviceTrackingController@feature_flags');
        Route::post('tracking', 'Api\DeviceTrackingController@create_track');
        Route::post('feature_track', 'Api\DeviceTrackingController@feature_track');
        Route::post('feedback', 'Api\DeviceTrackingController@feedback');
    });
});

Route::group(['prefix' => 'statics'], function () {
    Route::get('table', function () {
        $data = [
            [
                'value' => collect(\Cache::getRedis()->keys('laravel_cache:traceing_*'))->count(),
                'label' => 'Cached IPs',
            ],
            [
                'value' => \App\Model\Device::count(),
                'label' => 'Devices',
            ],
            [
                'value' => \App\Model\Device\Tracking::count(),
                'label' => 'Device Trackings',
            ],
            [
                'value' => \App\Model\Message::onlyParents()->count(),
                'label' => 'Status Messages',
            ],
        ];

        return response()->json($data);
    });
    Route::get('monthly_active_devices', function () {
        $data = [
            [
                'value' => \App\Model\Device::whereHas('trackings', function ($query) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::now()->startOfMonth(),
                        \Carbon\Carbon::now()->endOfMonth(),
                    ]);
                })->count(),
                'label' => 'Active Users',
                'color' => '#17c11c',
            ],
            [
                'value' => \App\Model\Device::whereDoesntHave('trackings', function ($query) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::now()->startOfMonth(),
                        \Carbon\Carbon::now()->endOfMonth(),
                    ]);
                })->count(),
                'label' => 'Other Users',
                'color' => '#ff0000',
            ],
        ];

        return response()->json($data);
    });
    Route::get('weekly_active_devices', function () {
        $data = [
            [
                'value' => \App\Model\Device::whereHas('trackings', function ($query) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::now()->startOfWeek(),
                        \Carbon\Carbon::now()->endOfWeek(),
                    ]);
                })->count(),
                'label' => 'Active Users',
                'color' => '#17c11c',
            ],
            [
                'value' => \App\Model\Device::whereDoesntHave('trackings', function ($query) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::now()->startOfWeek(),
                        \Carbon\Carbon::now()->endOfWeek(),
                    ]);
                })->count(),
                'label' => 'Other Users',
                'color' => '#ff0000',
            ],
        ];

        return response()->json($data);
    });
    Route::get('daily_active_devices', function () {
        $data = [
            [
                'value' => \App\Model\Device::whereHas('trackings', function ($query) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::yesterday()->startOfDay(),
                        \Carbon\Carbon::now()->startOfDay(),
                    ]);
                })->count(),
                'label' => 'Active Users',
                'color' => '#17c11c',
            ],
            [
                'value' => \App\Model\Device::whereDoesntHave('trackings', function ($query) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::yesterday()->startOfDay(),
                        \Carbon\Carbon::now()->startOfDay(),
                    ]);
                })->count(),
                'label' => 'Other Users',
                'color' => '#ff0000',
            ],
        ];

        return response()->json($data);
    });
    Route::get('os', function () {
        return response()->json(DB::table('devices')->select(DB::raw('COUNT(*) as value, os as label'))->groupBy('os')->orderBy('os')->get()->map(function (
            $report
        ) {
            if ($report->label == 'Android') {
                $report->color = '#89BF64';
            } else {
                if ($report->label == 'browser') {
                    $report->color = '#F7D247';
                } else {
                    if ($report->label == 'iOS') {
                        $report->color = '#327BF6';
                    }
                }
            }

            return $report;
        }));
    });
    Route::get('app_version', function () {
        return response()->json(DB::table('devices')->select(DB::raw('COUNT(*) as value, app_version as label'))->groupBy('app_version')->orderByRaw('COUNT(*) DESC')->limit(10)->get()->reject(function (
            $v
        ) {
            return $v->label == null;
        })->map(function ($v) {
            $v->label = str_replace('My Hetzner/', '', $v->label);

            return $v;
        }));
    });
    Route::get('trackings', function () {
        return response()->json(DB::table('trackings')->select(DB::raw('COUNT(*) as value, type as label'))->groupBy('type')->get());
    });
    Route::get('devices_created', function () {
        return response()->json(DB::table('devices')->select(DB::raw('COUNT(*) as y, DATE_FORMAT(created_at, "%Y-%m-%d") as x'))->whereBetween('created_at', [
            \Carbon\Carbon::now()->startOfDay()->subDay(30),
            \Carbon\Carbon::now()->endOfDay(),
        ])->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'))->get()->sortBy('x'));
    });
    Route::get('devices_created_hourly', function () {
        return response()->json(DB::table('devices')->select(DB::raw('COUNT(*) as y, DATE_FORMAT(created_at, "%k") as x'))->whereBetween('created_at', [
            \Carbon\Carbon::now()->startOfHour()->subHours(23),
            \Carbon\Carbon::now()->endOfHour(),
        ])->groupBy(DB::raw('DATE_FORMAT(created_at, "%k")'))->orderByRaw('DATE_FORMAT(created_at, "%k")')->get()->sortBy('x'));
    });

    Route::get('features_all', function () {
        return response()->json(DB::table('feature_trackings')->select(DB::raw('SUM(value) as value, feature as label'))->groupBy([
            'device_id',
            'feature',
        ])->orderByRaw('SUM(value) DESC')->limit(10)->get());
    });
    Route::get('features_current_month', function () {
        return response()->json(DB::table('feature_trackings')->select(DB::raw('SUM(value) as value, feature as label'))->whereBetween('created_at', [
            \Carbon\Carbon::now()->startOfMonth(),
            \Carbon\Carbon::now()->endOfMonth(),
        ])->groupBy(['device_id', 'feature'])->get());
    });
    Route::get('features_last_month', function () {
        return response()->json(DB::table('feature_trackings')->select(DB::raw('SUM(value) as value, feature as label'))->whereBetween('created_at', [
            \Carbon\Carbon::now()->subMonth()->startOfMonth(),
            \Carbon\Carbon::now()->subMonth()->endOfMonth(),
        ])->groupBy(['device_id', 'feature'])->get());
    });
    Route::get('{device_id}/features_all', function ($deviceId) {
        return response()->json(DB::table('feature_trackings')->select(DB::raw('SUM(value) as value, feature as label'))->groupBy([
            'device_id',
            'feature',
        ])->where('device_id', '=', $deviceId)->get());
    });
    Route::get('{device_id}/features_current_month', function ($deviceId) {
        return response()->json(DB::table('feature_trackings')->select(DB::raw('SUM(value) as value, feature as label'))->whereBetween('created_at', [
            \Carbon\Carbon::now()->startOfMonth(),
            \Carbon\Carbon::now()->endOfMonth(),
        ])->groupBy(['device_id', 'feature'])->where('device_id', '=', $deviceId)->get());
    });
    Route::get('{device_id}/features_last_month', function ($deviceId) {
        return response()->json(DB::table('feature_trackings')->select(DB::raw('SUM(value) as value, feature as label'))->whereBetween('created_at', [
            \Carbon\Carbon::now()->subMonth()->startOfMonth(),
            \Carbon\Carbon::now()->subMonth()->endOfMonth(),
        ])->groupBy(['device_id', 'feature'])->where('device_id', '=', $deviceId)->get());
    });

    Route::get('avg_created_accounts', function () {
        $avg_projects = collect([]);
        $avg_access = collect([]);
        \App\Model\Device::whereHas('trackings')->get()->each(function (\App\Model\Device $d) use (
            &$avg_access,
            &
            $avg_projects
        ) {
            $tmp = $d->latest_track();
            if ($tmp != null) {
                $avg_projects->push($tmp->projects);
                $avg_access->push($tmp->access);
            }
        });
        $data = [
            [
                'value' => round($avg_access->avg(), 5),
                'label' => 'Cloud ('.$avg_access->count().')',
                'color' => '#17c11c',
            ],
            [
                'value' => round($avg_projects->avg(), 5),
                'label' => 'Robot ('.$avg_projects->count().')',
                'color' => '#ff0000',
            ],
        ];

        return response()->json($data);
    });
});

Route::get('_internal/builds/{version_code}', 'Internal\Api\BuildController@getBuildNumber');