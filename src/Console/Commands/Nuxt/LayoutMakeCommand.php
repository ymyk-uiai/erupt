<?php

namespace Erupt\Console\Commands\Nuxt;

use Erupt\Console\Commands\BaseCommand;

class LayoutMakeCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erupt:layout {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a nuxt layout class';

    protected $type = 'Layout';

    protected function getStub()
    {
        $type = $this->model->getType();

        $name = "layout." . lcfirst($this->argument("name"));

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

        return $this->laravel->basePath("client/layouts/$model/$path");
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