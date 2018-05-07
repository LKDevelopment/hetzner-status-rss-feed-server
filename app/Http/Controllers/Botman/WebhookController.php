<?php

namespace App\Http\Controllers\Botman;

use App\Model\Message;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Carbon\Carbon;

class WebhookController extends \App\Http\Controllers\Controller
{

    public function telegram()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
        DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);
        $config = [
            // Your driver-specific configuration
            "telegram" => [
                "token" => getenv('TELEGRAM_TOKEN'),
            ],
            'facebook' => [
                'token' => getenv('FACEBOOK_PAGE_TOKEN'),
                'app_secret' => getenv('FACEBOOK_APP_SECRET'),
                'verification' => getenv('SECRET_VERIFICATION_TOKEN'),
            ],
        ];
        $botman = BotManFactory::create($config);
        $botman->hears('/start', function ($bot) {
            $bot->reply('Hello! Just write me what you want to know like so:');
            $bot->reply('nbg');
            $bot->reply('And i will answer you if there are any messages! Just try it out :)');
        });
        $botman->hears('/help', function ($bot) {
            $bot->reply('Hello! Just write me what you want to know like so:');
            $bot->reply('nbg');
            $bot->reply('And i will answer you if there are any messages! Just try it out :)');
        });
        $botman->hears('{keyword}', function ($bot, $keyword) {
            if (str_contains($keyword, ['start', 'help']) == false) {
                $keyword = explode(PHP_EOL, str_replace(' ', '', $keyword))[0];
                $messages = Message::where('title_en', 'LIKE', '%' . $keyword . '%')->onlyParents()->where('created_at', '>', Carbon::now()->subDays(2)->startOfDay())->get();

                try {
                    if ($messages->count() == 0) {
                        $bot->reply("I've found nothing for the keyword: " . $keyword);
                        echo "Nothing found";
                    } else {
                        $bot->reply("I found " . $messages->count() . " Messages for this");
                        foreach ($messages as $message) {
                            $bot->reply($message->title_en . ' ' . $message->permalink_en);
                        }

                    }
                } catch (\Exception $e) {

                }
            }
        });
        $botman->fallback(function ($bot) {
            $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
        });
// Process incoming message
        $botman->listen();
    }
}