<?php

namespace Erupt\Console\Commands\Nuxt;

use Erupt\Console\Commands\BaseCommand;

class ComponentMakeCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:component {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a nuxt component class';

    protected $type = 'Component';

    protected function getStub()
    {
        $type = $this->model->getType();

        $name = "component." . lcfirst($this->argument("name"));

        $template = null;

        //$template = $template ?? "/templates/laravel/$type/controller.txt";

        $template = $this->app->front->getTemplatePath($type, $name);

        return $this->resolveStubPath($template);
    }

    protected function updatePath($path)
    {
        //  https://gist.github.com/jasondmoss/6200807
        $path = substr($path, strrpos($path, '/') + 1);

        $model = $this->model->getName().'s';

        return $this->laravel->basePath("client/components/$model/$path");
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