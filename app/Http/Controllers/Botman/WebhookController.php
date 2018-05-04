<?php

namespace App\Http\Controllers\Botman;

use App\Model\Message;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Carbon\Carbon;

class WebhookController extends \App\Http\Controllers\Controller
{
    public function telegram(){
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
        $config = [
            // Your driver-specific configuration
             "telegram" => [
                "token" => getenv('TELEGRAM_TOKEN')
            ]
        ];
        $botman = BotManFactory::create($config);
        $botman->hears('{keyword}', function ($bot, $keyword) {

            $keyword = explode(PHP_EOL, ltrim(trim($keyword)))[0];
            $messages = Message::where('title_en', 'LIKE', '%' . $keyword . '%')->onlyParents()->where('created_at', '>', Carbon::now()->subDays(2)->startOfDay())->get();

            try {
                if ($messages->count() == 0) {
                    $bot->reply("I've found something:". $messages->map(function ($m) { return $m->permalink_en; })->implode(' '));
                    echo "Nothing found";
                } else {
                    $bot->reply("I've found something:". $messages->map(function ($m) { return $m->permalink_en; })->implode(' '));
                }
            } catch (\Exception $e) {

            }
        });
// Process incoming message
        $botman->listen();
    }
}