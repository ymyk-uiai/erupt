<?php

namespace Erupt\Providers;

use Illuminate\Support\ServiceProvider;
use Erupt\Console\EruptCommand;
use Erupt\Console\Commands\Laravel\ControllerMakeCommand as LaravelControllerMakeCommand;
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
            // publish config file
            
            $this->commands([
                EruptCommand::class,
                LaravelControllerMakeCommand::class,
            ]);
        }
    }
}
