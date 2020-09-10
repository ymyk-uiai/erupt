<?php

namespace Erupt\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Erupt\Application;
use Erupt\Language\EruptLang;

abstract class BaseCommand extends GeneratorCommand
{
    protected $app;

    protected $model;

    public function __construct(Filesystem $files, Application $app)
    {
        parent::__construct($files);

        $this->app = $app;
    }
    
    public function handle()
    {
        $modelName = $this->option("model");

        $this->model = $this->app->getModels()->get($modelName);

        $name = $this->qualifyClass($this->getNameInput());
            //  make sure $name start with App\ etc.
            //  if you makes controller, $name starts with App\Http\Controllers

        $path = $this->getPath($name);
            //  get a file path from the namespace
            //  App\Http\Controllers -> {projectRootDirectory}/app/Http/Controllers

        $this->makeDirectory($path);

        $this->files->put($path, $this->build($modelName));

        $this->info($this->type.' created successfully.');
    }

    protected function build($name)
    {
        $template = $this->files->get($this->getStub());

        $eruptLang = new EruptLang($this->app);

        return $eruptLang->exec($template, $name);
    }
}