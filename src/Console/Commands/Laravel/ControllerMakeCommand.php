<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\BaseCommand;

class ControllerMakeCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:controller {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a laravel controller class';

    protected $type = 'Controller';

    protected function getStub()
    {
        $type = $this->model->getType();

        $template = null;

        //$template = $template ?? "/templates/laravel/$type/controller.txt";

        $template = $this->app->server->getTemplatePath($type, "controller");

        return $this->resolveStubPath($template);
    }

    /**
     * Illuminate\Routing\Console\ControllerMakeCommand::resolveStubPath
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }
}