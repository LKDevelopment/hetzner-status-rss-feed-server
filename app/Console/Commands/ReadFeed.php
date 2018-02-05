<?php

namespace App\Console\Commands;

use App\StatusMeldung;
use ArandiLopez\Feed\Facades\Feed;
use Illuminate\Console\Command;
use PHPHtmlParser\Dom;

class ReadFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:feed';

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
        $myFeed = Feed::make('https://www.hetzner-status.de/de.atom');
        collect($myFeed->getItems())->map(function ($item) {
            $_doms = new Dom();
            $_doms->load($item->toArray()['content']);
            $doms = $_doms->find('div');
            $category = '';
            $text = '';
            foreach ($doms as $dom) {
                $_type = $dom->find('strong');

                if ($_type->innerHTML == 'Kategorie') {
                    $type = $dom->find('li')->innerHTML;
                    $category = $type;
                }
                if ($_type->innerHTML == 'Beschreibung') {
                    $text = $dom->find('p')->innerHTML;
                    $_links = new Dom();
                    $_links->load($text);
                    $links = $_links->find('a');
                    foreach ($links as $link) {
                        $link->delete();
                        unset($link);
                    }
                    $text = (string) $_links;
                }
            }
            $message = StatusMeldung::where('date_time', '=', $item->date)->where('category', '=', $category)->first();
            if ($message == null) {
                StatusMeldung::create([
                    'title' => $item->title,
                    'text' => $text,
                    'category' => $category,
                    'date_time' => $item->date,
                ]);
            }
        });
    }
}
