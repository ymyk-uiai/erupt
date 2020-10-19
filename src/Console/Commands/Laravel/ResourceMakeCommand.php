<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\BaseCommand;

class ResourceMakeCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:resource {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a laravel resource class';

    protected $type = 'Resource';

    protected function getStub()
    {
        $type = $this->model->getType();

        $template = null;

        //$template = $template ?? "/templates/laravel/$type/controller.txt";

        $template = $this->app->server->getTemplatePath($type, "resource");

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
        return $rootNamespace.'\Http\Resources';
    }
}