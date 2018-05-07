<?php

namespace App\Console\Commands;

use App\Libaries\Traceroute;
use Illuminate\Console\Command;

class testTrace extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:trace {ip}';

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
        /*$trace = new Traceroute();
        var_dump($trace->trace($this->argument('ip')));*/
        $output = '';
        exec('traceroute ' . escapeshellarg($this->argument('ip')), $output);
        $hosts = [];
        foreach ($output as $index => $line) {
            if($index == 0) continue;
            $line_parts = explode(' ', ltrim($line));
            if (!empty($line_parts) && $line_parts[2] != '*' && $line_parts[2] != '3') {
                $ip = str_replace(['(', ')'], '', $line_parts[3]);
                $host = $line_parts[2];
                if ($ip == $host) {
                    $host = gethostbyaddr($ip);
                }
                $hosts[] = [$ip => $host];
            }
        }
        var_dump($hosts);
    }
}
