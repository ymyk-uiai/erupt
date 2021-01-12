<?php

namespace Erupt\Console\Commands\Nuxt;

use Erupt\Console\Commands\Nuxt\NuxtCommand;

class ComponentMakeCommand extends NuxtCommand
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

    protected $namespace = "components";

    protected $extention = "vue";

    protected function getStub()
    {
        $type = $this->model->get_type();

        $name = "component." . lcfirst($this->argument("name"));

        $template = null;

        $template = $this->generator->getBasePath() . "/models/$type/$name.txt";

        return $this->resolveStubPath($template);
    }

    protected function updateName($name)
    {
        $type = $this->model->get_type();

        return "$type/$name";
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