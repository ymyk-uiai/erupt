<?php

namespace Erupt\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Erupt\Application;
use Erupt\Language\EruptLang;
use Erupt\Generators\PhpClassMaker;

abstract class BaseCommand extends GeneratorCommand
{
    protected $app;

    protected $model;

    protected $basePath;

    public function __construct(Filesystem $files, Application $app)
    {
        parent::__construct($files);

        $this->app = $app;
    }

    public function handle()
    {
        $modelName = $this->option("model");

        $this->model = $this->app->getModels()->get($modelName);

        $this->basePath = $this->laravel->basePath();

        $name = $this->getMakeName($this->getNameInput());

        $path = $this->getPath($this->getNameInput());

        $this->makeDirectory($path);

        $this->files->put($path, $this->build($modelName));

        $this->info($this->type.' created successfully.');
    }

    protected function getMakeName($name)
    {
        return trim($this->baseNamespace, "\\/") . "\\" . trim($this->namespace, "\\/") . "\\" . trim($name, "\\/");
    }

    protected function getPath($name)
    {
        $basePath = trim($this->basePath, "\\/");

        $baseDirectory = trim($this->baseDirectory, "\\/");

        $commandDirectory = str_replace("\\", "/", $this->namespace);

        $name = $this->updateName($name);

        $extention = $this->extention;

        return "$baseDirectory/$commandDirectory/$name.$extention";
    }

    protected function updateName($name)
    {
        return $name;
    }

    protected function updatePath($path)
    {
        return $path;
    }

    protected function build($name)
    {
        $template = $this->makeTemplate($this->files->get($this->getStub()));

        $template = $this->updateUse($template);

        $data = $this->cropData($template);

        $template = $this->cropTemplate($template);

        $json = json_decode(trim($data), true);

        if(!array_key_exists("events", $json)) {
            $json["events"] = [];
        }

        $events = $json["events"];

        foreach($events as $event) {
            $this->app->dispatch($event);
        }

        $eruptLang = new EruptLang($this->app);

        return $eruptLang->exec($template, $name, lcfirst($this->type));
    }

    protected function getNestedComponents($component)
    {
        $data = $this->cropData($component);

        $json = json_decode(trim($data), true);

        $components = $json["components"] ?? [];

        $result = [];

        foreach($components as $component) {
            $dir = $this->app->server->getComponentDir();

            $c = $this->files->get("$dir$component.txt");

            $result[$component] = $c;
        }
        
    
        return $result;
    }

    protected function updateComponent($parent, $child, $name)
    {
        $parentTemplate = $this->cropTemplate($parent);

        $parentData = $this->cropData($parent);

        $childTemplate = $this->cropTemplate($child);

        $childData = $this->cropData($child);

        $parentTemplate = $this->mergeTemplate($parentTemplate, $childTemplate, $name);

        $parentData = $this->mergeData($parentData, $childData);

        $updated = $this->makeComponent($parentTemplate, $parentData);

        return $updated;
    }

    protected function cropTemplate($component)
    {
        $data = $this->cropData($component);

        $result = preg_replace("/".preg_quote("<data>$data</data>", '/')."/", '', $component);

        return $result;
    }

    protected function cropData($component)
    {
        $pattern = "/<data>(.*)<\/data>/s";

        preg_match($pattern, $component, $matches);

        return $matches[1];
    }

    protected function mergeTemplate($parent, $child, $name)
    {
        return str_replace("@$name", trim($child), $parent);
    }

    protected function mergeData($parent, $child)
    {
        $parentJson = json_decode($parent, true);

        $childJson = json_decode($child, true);

        if(!array_key_exists("use", $parentJson)) {
            $parentJson["use"] = [];
        }

        if(!array_key_exists("use", $childJson)) {
            $childJson["use"] = [];
        }

        $parentJson["use"] = array_merge($parentJson["use"], $childJson["use"]);

        if(!array_key_exists("events", $parentJson)) {
            $parentJson["events"] = [];
        }

        if(!array_key_exists("events", $childJson)) {
            $childJson["events"] = [];
        }

        $parentJson["events"] = array_merge($parentJson["events"], $childJson["events"]);

        return json_encode($parentJson);
    }

    protected function makeComponent($template, $data)
    {
        return "$template<data>$data</data>";
    }

    protected function makeTemplate($baseComponent)
    {
        $innerComponents = $this->getNestedComponents($baseComponent);

        foreach($innerComponents as $key => $value) {
            $processed = $this->makeTemplate($value);

            $baseComponent = $this->updateComponent($baseComponent, $processed, $key);
        }

        return $baseComponent;
    }

    protected function updateUse($component)
    {
        $data = $this->cropData($component);

        $dataJson = json_decode($data, true);

        $uses = implode(";", $dataJson["use"]);

        $uses = array_map(function ($n) {
            return "use $n;";
        }, $dataJson["use"]);

        $uses = implode("\n", $uses);

        return str_replace("@use", $uses, $component);
    }
}