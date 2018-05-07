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
    protected $signature = 'test:trace';

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
        $trace = new Traceroute();
        $trace->trace('hetzner-status.lkdev.co');
    }
}
