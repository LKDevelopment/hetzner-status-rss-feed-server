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
    protected $signature = 'read:feed {language=de}';

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
        $language = $this->argument('language');
        $myFeed = Feed::make('https://www.hetzner-status.de/'.$language.'.atom');

        $languages = [
            'de' => [
                'category' => 'Kategorie',
                'text' => 'Beschreibung',
                'affected' => 'Betroffen',
                'update' => 'Update',

            ],
            'en' => [
                'category' => 'Category',
                'text' => 'Description',
                'affected' => 'Affected',
                'update' => 'Update',
            ],
        ];
        $output = $this;
        $output->info(count($myFeed->getItems()).' founded');
        $output->output->progressStart(count($myFeed->getItems()));
        collect($myFeed->getItems())->map(function ($item) use ($language, $languages, $output) {

            $category = '';
            $text = '';
            $_external_id = explode('#', $item->permalink);
            $external_id = end($_external_id);

            $parentId = null;
            if (str_contains($external_id, '-')) {
                $_parent_id = explode('-', $external_id);
                $parentId = $_parent_id[0];
            }
            if ($parentId == null) {
                $content = $item->toArray()['content'];
            } else {
                $content = '<div>'.$item->toArray()['content'].'</div>';
            }
            $_doms = new Dom();
            $_doms->load($content);
            $doms = $_doms->find('div');
            foreach ($doms as $dom) {
                $_type = $dom->find('strong');

                if ($_type->innerHTML == $languages[$language]['category']) {
                    $type = $dom->find('li')->innerHTML;
                    $category = $type;
                }
                if ($parentId == null) {
                    if ($_type->innerHTML == $languages[$language]['text']) {
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
                    if ($_type->innerHTML == $languages[$language]['affected']) {
                        $affected = $dom->find('p')->innerHTML;
                        $_links = new Dom();
                        $_links->load($affected);
                        $links = $_links->find('a');
                        foreach ($links as $link) {
                            $link->delete();
                            unset($link);
                        }
                        $text .= '<br /><strong>'.$languages[$language]['affected'].':</strong> '.(string) $_links;
                    }
                } else {
                    if ($_type->innerHTML == $languages[$language]['update']) {
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
            if ($parentId != null) {
                $parent = StatusMeldung::where('external_id', '=', $parentId)->first();
                if ($parent == null) {
                    return;
                }
                $category = $parent->category;
            }
            $message = StatusMeldung::where('external_id', '=', $external_id)->where('language', '=', $language)->first();
            if ($message == null && $category != '') {
                $message = StatusMeldung::create([
                    'title' => $item->title,
                    'text' => $text,
                    'category' => $category,
                    'date_time' => $item->date,
                    'external_id' => $external_id,
                    'parent_id' => $parentId,
                    'permalink' => $item->permalink,
                    'language' => $language,
                ]);
            }
            $this->output->progressAdvance();
        });
        $this->output->progressFinish();
    }
}
