<?php

namespace App\Console\Commands;

use App\Model\Message;
use Berkayk\OneSignal\OneSignalClient;
use Carbon\Carbon;
use Illuminate\Console\Command;

class checkForNewNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newMessages = Message::whereNull('send_at')->whereNotNull('title_de')->whereNotNull('title_en')->get();
        $apps = ['hetzner-status-app' => 'HetznerStatusApp'];
        foreach ($newMessages as $newMessage) {
            $headings = [
                "en" => $newMessage->title_en,
                "de" => $newMessage->title_de,
            ];
            $contents = [
                "en" => \Stevebauman\Purify\Facades\Purify::clean($newMessage->description_en, ['HTML.Allowed' => '']),
                "de" => \Stevebauman\Purify\Facades\Purify::clean($newMessage->description_de, ['HTML.Allowed' => '']),
            ];
            $category = $newMessage->category;
            if ($newMessage->parent_id != null) {
                $category = $newMessage->parent->category.'.'.$newMessage->parent->type;
            }
            $tags = [
                [
                    "key" => $category.'.'.$newMessage->type,
                    "relation" => "=",
                    "value" => true,
                ]
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
                    'data' => ['page' => 'status','statusId' => $newMessage->external_id]
                ]);
            }
            $newMessage->update(['send_at' => Carbon::now()]);
        }
    }
}
