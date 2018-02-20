<?php

namespace App\Console\Commands;

use App\Model\Message;
use ArandiLopez\Feed\Facades\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;

class GetMessagesFromFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $languages = [
        'de' => [
            'category' => 'Kategorie',
            'text' => 'Beschreibung',
            'affected' => 'Betroffen',
            'update' => 'Update',
            'type' => 'Typ',
            'start' => 'Start',
            'end' => 'Ende',
            'categories' => [
                "Allgemein" => "general",
                "Basis Infrastruktur" => "basic_infrastructur",
                "Erweiterte Infrastruktur" => "advanced_infrastructur",
                "Netzwerk" => "network",
                "Webhosting und Managed Server" => "webhosting_and_managed_server",
                "Domain Registration Robot" => "domain_registration_robot",
                "vServer" => "v_servers",
                "Cloud" => "cloud",
            ],
            'types' => [
                'Störungsmeldung' => 'fault_report',
                'Wartungsarbeiten' => 'maintaince_work',
                'Sonstiges' => 'miscellaneous',
            ],
        ],
        'en' => [
            'category' => 'Category',
            'text' => 'Description',
            'affected' => 'Affected',
            'update' => 'Update',
            'type' => 'Type',
            'start' => 'Start',
            'end' => 'End',
            'categories' => [
                "General" => "general",
                "Basic infrastructure" => "basic_infrastructur",
                "Advanced infrastructure" => "advanced_infrastructur",
                "Network" => "network",
                "Web hosting and managed servers" => "webhosting_and_managed_server",
                "Domain Registration Robot" => "domain_registration_robot",
                "vServers" => "v_servers",
                "Cloud" => "cloud",
            ],
            'types' => [
                'Fault report' => 'fault_report',
                'Maintenance work' => 'maintenance_work',
                'Miscellaneous' => 'miscellaneous',
            ],
        ],
    ];

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
        $feedUrls = ['de' => 'https://hetzner-status.de/de.atom', 'en' => 'https://hetzner-status.de/en.atom'];
        foreach ($feedUrls as $languageCode => $feedUrl) {
            $data_from_feed = Feed::make($feedUrl);
            $output = $this;
            $items = $data_from_feed->getItems();
            $items_count = count($items);
            $output->info($items_count.' founded');
            $output->output->progressStart($items_count);

            collect($items)->map(function ($item) use ($languageCode) {
                $external_id = $this->getExternalId($item->permalink);
                $parent_id = $this->getParentId($external_id);
                $message = Message::where('external_id', '=', $external_id)->first();
                $content = $item->toArray()['content'];
                $content = ($parent_id == null) ? $content : ("<div>".$content."</div>");
                $dom = new Dom();
                $dom->load($content);
                $nodes = $dom->find('div');
                $_payload = [
                    'title_'.$languageCode => $item->title,
                    'description_'.$languageCode => null,
                    'affected_'.$languageCode => null,
                    'permalink_'.$languageCode => $item->permalink,
                    'category' => null,
                    'start' => null,
                    'end' => null,
                    'external_id' => $external_id,
                    'parent_id' => $parent_id,
                ];
                foreach ($nodes as $node) {
                    $_line = $node->find('strong');
                    if ($parent_id == null) {
                        if ($_line->innerHTML == $this->languages[$languageCode]['category']) {
                            $type = $node->find('li')->innerHTML;
                            if (str_contains($type, ',')) {
                                $_category = explode(',', $type);
                                $type = end($_category);
                            }
                            $_payload['category'] = $this->languages[$languageCode]['categories'][(string) $type];
                        }
                        if ($_line->innerHTML == $this->languages[$languageCode]['type']) {
                            $__type = $node->find('p')->innerHTML;
                            $_type = new Dom();
                            $_type->load($__type);
                            $type_d_links = $_type->find('a');
                            foreach ($type_d_links as $link) {
                                $link->delete();
                                unset($link);
                            }
                            $_payload['type'] = $this->languages[$languageCode]['types'][(string) $_type];
                        }
                        if ($_line->innerHTML == $this->languages[$languageCode]['text']) {
                            $text = $node->find('p')->innerHTML;
                            $_links = new Dom();
                            $_links->load($text);
                            $links = $_links->find('a');
                            foreach ($links as $link) {
                                $link->delete();
                                unset($link);
                            }
                            $_payload['description_'.$languageCode] = (string) $_links;
                        }
                        if ($_line->innerHTML == $this->languages[$languageCode]['affected']) {
                            $affected = $node->find('p')->innerHTML;
                            $_affected_links = new Dom();
                            $_affected_links->load($affected);
                            $affected_links = $_affected_links->find('a');
                            foreach ($affected_links as $__link) {
                                $__link->delete();
                                unset($__link);
                            }
                            $_payload['affected_'.$languageCode] = (string) $_affected_links;
                        }
                        if ($_line->innerHTML == $this->languages[$languageCode]['start']) {
                            $start = $node->find('p')->innerHTML;
                            $_payload['start'] = (string) $start;
                        }
                        if ($_line->innerHTML == $this->languages[$languageCode]['end']) {
                            $end = $node->find('p')->innerHTML;
                            $_payload['end'] = (string) $end;
                        }
                    } else {
                        if ($_line->innerHTML == $this->languages[$languageCode]['update']) {
                            $text = $node->find('p')->innerHTML;
                            $_links = new Dom();
                            $_links->load($text);
                            $links = $_links->find('a');
                            foreach ($links as $link) {
                                $link->delete();
                                unset($link);
                            }
                            $_payload['description_'.$languageCode] = (string) $_links;
                        }
                        $_payload['type'] = 'update';
                    }
                }

                if ($message == null) {
                    $message = Message::create($_payload);
                    Log::stack(['slack_info'])->info('Neue Nachricht: Lang:'.$languageCode.' ID:'.$external_id);
                } else {
                    $message->update($_payload);
                }
            });
        }
    }

    protected function getExternalId($permalink)
    {
        $_external_id = explode('#', $permalink);

        return end($_external_id);
    }

    protected function getParentId($externalId)
    {
        if (str_contains($externalId, '-')) {
            $parts = explode('-', $externalId);

            return array_first($parts);
        }

        return null;
    }
}
