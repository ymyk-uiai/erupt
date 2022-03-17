<?php

namespace Erupt\Console;

use Illuminate\Console\Command;
use Erupt\Application;

class EruptResetCommand extends Command
{
    protected $signature = "erupt:reset";

    protected $description = 'Reset a Laravel app';

    protected Application $app;

    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }

    public function handle()
    {
        $this->call("migrate:reset");
        exec("git clean -fd");
        exec("git restore app database routes resources");
    }

}