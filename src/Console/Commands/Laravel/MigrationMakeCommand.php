<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\Laravel\LaravelCommand;

class MigrationMakeCommand extends LaravelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:migration {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a laravel migration';

    protected $type = 'Migration';

    protected $namespace = "migrations";

    protected string $baseDirectory = "database";

    protected function getStub()
    {
        $type = $this->model->getType();

        $template = null;

        $template = $this->generator->getBasePath() . "/models/$type/migration.txt";

        return $this->resolveStubPath($template);
    }

    protected function updatePath($path)
    {
        //  https://gist.github.com/jasondmoss/6200807
        $path = substr($path, strrpos($path, '/') + 1);

        $model = $this->model->getName().'s';

        return $this->laravel->basePath("database/migrations/$path");
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