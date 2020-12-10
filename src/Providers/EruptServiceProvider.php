<?php

namespace Erupt\Providers;

use Illuminate\Support\ServiceProvider;
use Erupt\Console\EruptCommand;
use Erupt\Console\Commands\Laravel\ModelMakeCommand as LaravelModelMakeCommand;
use Erupt\Console\Commands\Laravel\RequestMakeCommand as LaravelRequestMakeCommand;
use Erupt\Console\Commands\Laravel\ResourceMakeCommand as LaravelResourceMakeCommand;
use Erupt\Console\Commands\Laravel\CollectionMakeCommand as LaravelCollectionMakeCommand;
use Erupt\Console\Commands\Laravel\ControllerMakeCommand as LaravelControllerMakeCommand;
use Erupt\Console\Commands\Laravel\PolicyMakeCommand as LaravelPolicyMakeCommand;
use Erupt\Console\Commands\Laravel\FactoryMakeCommand as LaravelFactoryMakeCommand;
use Erupt\Console\Commands\Laravel\SeederMakeCommand as LaravelSeederMakeCommand;
use Erupt\Console\Commands\Laravel\MigrationMakeCommand as LaravelMigrationMakeCommand;

use Erupt\Console\Commands\Nuxt\ComponentMakeCommand as NuxtComponentMakeCommand;
use Erupt\Console\Commands\Nuxt\StoreMakeCommand as NuxtStoreMakeCommand;
use Erupt\Console\Commands\Nuxt\PageMakeCommand as NuxtPageMakeCommand;
use Erupt\Console\Commands\Nuxt\LayoutMakeCommand as NuxtLayoutMakeCommand;
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
                LaravelModelMakeCommand::class,
                LaravelRequestMakeCommand::class,
                LaravelResourceMakeCommand::class,
                LaravelCollectionMakeCommand::class,
                LaravelControllerMakeCommand::class,
                LaravelPolicyMakeCommand::class,
                LaravelFactoryMakeCommand::class,
                LaravelSeederMakeCommand::class,
                LaravelMigrationMakeCommand::class,
                NuxtComponentMakeCommand::class,
                NuxtStoreMakeCommand::class,
                NuxtPageMakeCommand::class,
                NuxtLayoutMakeCommand::class,
            ]);
        }
    }
}
