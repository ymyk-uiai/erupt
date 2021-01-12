<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\Laravel\LaravelCommand;

class RequestMakeCommand extends LaravelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:request {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a laravel request class';

    protected $type = 'Request';

    protected $namespace = "Http\\Requests";

    protected function getStub()
    {
        $type = $this->model->get_type();

        $template = null;

        $template = $this->generator->getBasePath() . "/models/$type/request.txt";

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
        return $rootNamespace.'\Http\Requests';
    }
}