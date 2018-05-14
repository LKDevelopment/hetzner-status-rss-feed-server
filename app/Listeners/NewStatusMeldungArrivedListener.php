<?php

namespace App\Listeners;

use App\Events\NewStatusMeldungArrived;
use Berkayk\OneSignal\OneSignalClient;

class NewStatusMeldungArrivedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewStatusMeldungArrived $event
     * @return void
     */
    public function handle(NewStatusMeldungArrived $event)
    {
        if ($event->meldung->language == 'de') {
            $headings = [
                "en" => $event->meldung->title,
                "de" => $event->meldung->title,
            ];
            $contents = [
                "en" => \Stevebauman\Purify\Facades\Purify::clean($event->meldung->text, ['HTML.Allowed' => '']),
                "de" => \Stevebauman\Purify\Facades\Purify::clean($event->meldung->text, ['HTML.Allowed' => '']),
            ];
            $tags = [
                [
                    "key" => $event->meldung->category,
                    "relation" => "=",
                    "value" => true,
                ],

            ];
            $apps = [
                'hetzner-cloud-app' => 'HetznerCloudApp',
               // 'hetzner-status-app' => 'HetznerStatusApp',
            ];
            foreach ($apps as $app => $envPrefix) {

                $oneSignalClient = new OneSignalClient(env($envPrefix.'_ONE_SIGNAL_APP_ID'), env($envPrefix.'_ONE_SIGNAL_REST_KEY'), env($envPrefix.'_ONE_SIGNAL_USER_KEY'));
                $oneSignalClient->sendNotificationCustom([
                    'contents' => $contents,
                    'headings' => $headings,
                    'tags' => $tags,
                    'android_group' => 'Hetzner-Status',
                    'android_group_message' => [
                        'en' => '$[notif_count] messages from Hetzner Status',
                        'de' => '$[notif_count] Status Meldungen von Hetzner',
                    ],
                    'data' => ['page' => 'status','statusId' => $event->meldung->external_id]
                ]);
            }
        }
    }
}
