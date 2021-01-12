<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\Laravel\LaravelCommand;

class CollectionMakeCommand extends LaravelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:collection {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a laravel collection class';

    protected $type = 'Collection';

    protected $namespace = "Http\\Resources";

    protected function getStub()
    {
        $type = $this->model->get_type();

        $template = null;

        $template = $this->generator->getBasePath() . "/models/$type/collection.txt";

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