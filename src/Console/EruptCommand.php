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
        foreach($this->app->getModels() as $model) {
            $commands = $this->app->server->getCommands($model);
            foreach($commands as $command) {
                $c = $this->app->server->makeCommand($command);
                $p = $this->app->server->makeParams($command, $model->getName());

                $this->call($c, $p);

                //$this->call($c, $p);
            }
            $commands = $this->app->front->getCommands($model);
            foreach($commands as $command) {
                $c = $this->app->front->makeCommand($command);
                $p = $this->app->front->makeParams($command, $model->getName());

                $this->call($c, $p);
            }
        }

        //print_r($this->app);
    }
}