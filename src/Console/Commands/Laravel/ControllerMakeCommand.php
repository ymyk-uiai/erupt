<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\Laravel\LaravelCommand;

class ControllerMakeCommand extends LaravelCommand
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

    protected $namespace = "Http\\Controllers";

    protected function getStub()
    {
        $type = $this->model->get_type();

        $template = null;

        $template = $this->generator->getBasePath() . "/models/$type/controller.txt";

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