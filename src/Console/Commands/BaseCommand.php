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

        $path = $this->updatePath($path);

        $this->makeDirectory($path);

        $this->files->put($path, $this->build($modelName));

        $this->info($this->type.' created successfully.');
    }

    protected function updatePath($path)
    {
        return $path;
    }

    protected function build($name)
    {
        $template = $this->makeTemplate($this->files->get($this->getStub()));

        $template = $this->updateUse($template);

        $template = $this->cropTemplate($template);

        $eruptLang = new EruptLang($this->app);

        return $eruptLang->exec($template, $name, lcfirst($this->type));
    }

    protected function getNestedComponents($component)
    {
        //print_r("getNestedComponents\n");

        $data = $this->cropData($component);

        $json = json_decode(trim($data), true);

        //print_r($data);
        //print_r($json);

        $components = $json["components"] ?? [];

        $result = [];

        foreach($components as $component) {
            $dir = $this->app->server->getComponentDir();

            $c = $this->files->get("$dir$component.txt");

            $result[] = $c;
        }
        
    
        return $result;
    }

    protected function updateComponent($parent, $child)
    {
        //print_r("updateComponent\n");

        $parentTemplate = $this->cropTemplate($parent);

        $parentData = $this->cropData($parent);

        $childTemplate = $this->cropTemplate($child);

        $childData = $this->cropData($child);

        //print_r($childData);
        $childDataJson = json_decode($childData, true);
        $name = $childDataJson["name"];

        $parentTemplate = $this->mergeTemplate($parentTemplate, $childTemplate, $name);

        $parentData = $this->mergeData($parentData, $childData);

        $updated = $this->makeComponent($parentTemplate, $parentData);

        return $updated;
    }

    protected function cropTemplate($component)
    {
        $pattern = "/<template>(.*)<\/template>/s";

        preg_match($pattern, $component, $matches);

        //print_r($matches);

        return $matches[1];
    }

    protected function cropData($component)
    {
        $pattern = "/<data>(.*)<\/data>/s";

        preg_match($pattern, $component, $matches);

        return $matches[1];
    }

    protected function mergeTemplate($parent, $child, $name)
    {
        //print_r("mergeTemplate : $name");
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

        return json_encode($parentJson);
    }

    protected function makeComponent($template, $data)
    {
        return "<template>$template</template><data>$data</data>";
    }

    protected function makeTemplate($baseComponent)
    {
        $innerComponents = $this->getNestedComponents($baseComponent);

        foreach($innerComponents as $inner) {
            $processed = $this->makeTemplate($inner);

            $baseComponent = $this->updateComponent($baseComponent, $processed);
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