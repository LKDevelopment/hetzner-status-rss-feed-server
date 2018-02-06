<?php

namespace App\Console\Commands;

use App\Events\NewStatusMeldungArrived;
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
            $_external_id = explode('#', $item->permalink);
            $external_id = end($_external_id);

            $parentId = null;
            if (str_contains($external_id, '-')) {
                $_parent_id = explode('-', $external_id);
                $parentId = $_parent_id[0];
            }
            foreach ($doms as $dom) {
                $_type = $dom->find('strong');

                if ($_type->innerHTML == 'Kategorie') {
                    $type = $dom->find('li')->innerHTML;
                    $category = $type;
                }
                if ($parentId == null) {
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
                    if ($_type->innerHTML == 'Betroffen') {
                        $text = $dom->find('p')->innerHTML;
                        $_links = new Dom();
                        $_links->load($text);
                        $links = $_links->find('a');
                        foreach ($links as $link) {
                            $link->delete();
                            unset($link);
                        }
                        $text .= '<strong>Betroffen:</strong> '.(string) $_links;
                    }
                } else {
                    if ($_type->innerHTML == 'Update') {
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
            }

            var_dump([
                'title' => $item->title,
                'text' => $text,
                'category' => $category,
                'date_time' => $item->date,
                'external_id' => $external_id,
                'parent_id' => $parentId,
                'permalink' => $item->permalink,
            ]);
            $message = StatusMeldung::where('external_id', '=', $external_id)->first();
            if ($message == null && $category != '') {
                $message = StatusMeldung::create([
                    'title' => $item->title,
                    'text' => $text,
                    'category' => $category,
                    'date_time' => $item->date,
                    'external_id' => $external_id,
                    'parent_id' => $parentId,
                    'permalink' => $item->permalink,
                ]);
                //event(new NewStatusMeldungArrived($message));
            }
        });
    }
}
