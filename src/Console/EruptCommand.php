<?php

namespace Erupt\Console;

use Illuminate\Console\Command;
use Erupt\Application;

class EruptCommand extends Command
{
    protected $signature = 'erupt';

    protected $description = 'Create your Laravel app';

    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }
    
    public function handle()
    {
        $seeds = $this->app->getCommandSeeds();

        foreach($seeds as $seed) {
            $command = $this->makeCommand($seed);
            $argsAndOptions = $this->makeArgsAndOptions($seed);

            $this->call($command, $argsAndOptions);
        }

        //print_r($this->app);
    }

    protected function makeCommand($seed)
    {
        print_r($seed);
        return "erupt:{$seed['command']}";
    }

    protected function makeArgsAndOptions($seed)
    {
        return [
            "name" => $seed["name"],
            "--model" => lcfirst($seed["modelName"]),
        ];
    }
}