<?php

namespace App\Console\Commands;

use App\Model\Message;
use App\StatusMeldung;
use Carbon\Carbon;
use Illuminate\Console\Command;
use TwitterStreamingApi;
use Thujohn\Twitter\Facades\Twitter;

class TweetListener extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet';

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
        TwitterStreamingApi::publicStream()
            ->whenHears('@HetzStatusBot', function (array $tweet) {
                $messages = Message::where('title_en', 'LIKE', '%' . $tweet['text'] . '%')->where('created_at', '>', Carbon::now()->subDays(2)->startOfDay())->get();
                if ($messages->count() == 0) {
                    Twitter::postTweet(['status' => 'Hey ' . $tweet['user']['screen_name'] . ", i've found nothing for your request!", 'format' => 'json']);
                } else {
                    Twitter::postTweet(['status' => 'Hey ' . $tweet['user']['screen_name'] . ", i've found something: " . $messages->map(function ($m) { return $m->permalink_en; })->implode(' '), 'format' => 'json']);
                }

                echo "{$tweet['user']['screen_name']} tweeted {$tweet['text']}";
            })
            ->startListening();
    }
}