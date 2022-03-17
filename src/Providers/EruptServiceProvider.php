<?php

namespace Erupt\Providers;

use Illuminate\Support\ServiceProvider;
use Erupt\Console\EruptActivateCommand;
use Erupt\Console\EruptMakeCommand;
use Erupt\Console\EruptResetCommand;
use Erupt\Application;

class EruptServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Application::class, function ($app) {
            return new Application(json_decode(file_get_contents(base_path('./erupt.json')), TRUE));
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            
            $this->commands([
                EruptActivateCommand::class,
                EruptMakeCommand::class,
                EruptResetCommand::class,
            ]);
        }
    }
}
