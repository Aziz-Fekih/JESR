<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitProjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop database, install passport and run seeds';

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
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->call('passport:install');
    }
}
