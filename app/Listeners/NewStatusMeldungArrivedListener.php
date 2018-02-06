<?php

namespace App\Listeners;

use App\Events\NewStatusMeldungArrived;
use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $headings = [
            "en" => $event->meldung->title,
            "de" => $event->meldung->title,
        ];
        $contents = [
            "en" => $event->meldung->text,
            "de" => $event->meldung->title,
        ];
        $tags = [["key" => $event->meldung->category, "relation" => "=", "value" => true]];
        OneSignalFacade::sendNotificationCustom([
            'contents' => $contents,
            'headings' => $headings,
            'tags' => $tags,
            'android_group' => 'Hetzner-Status',
            'android_group_message' => [
                'en' => '$[notif_count] messages from Hetzner Status',
                'de' => '$[notif_count] Status Meldungen von Hetzner',
            ],
        ]);
    }
}
