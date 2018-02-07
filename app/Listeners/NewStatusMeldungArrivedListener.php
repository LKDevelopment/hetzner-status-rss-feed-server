<?php

namespace App\Listeners;

use App\Events\NewStatusMeldungArrived;
use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Stevebauman\Purify\Purify;

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
                "en" => Purify::clean($event->meldung->text, ['HTML.Allowed' => '']),
                "de" => Purify::clean($event->meldung->text, ['HTML.Allowed' => '']),
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
}
