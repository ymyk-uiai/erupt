<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\Laravel\LaravelCommand;

class FactoryMakeCommand extends LaravelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:factory {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a laravel factory';

    protected $type = 'Factory';

    protected $namespace = "factories";

    protected string $baseDirectory = "database";

    protected function getStub()
    {
        $type = $this->model->getType();

        $template = null;

        $template = $this->generator->getBasePath() . "/models/$type/factory.txt";

        return $this->resolveStubPath($template);
    }

    protected function updatePath($path)
    {
        //  https://gist.github.com/jasondmoss/6200807
        $path = substr($path, strrpos($path, '/') + 1);

        $model = $this->model->getName().'s';

        return $this->laravel->basePath("database/factories/$path");
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
        return $rootNamespace;
    }
}