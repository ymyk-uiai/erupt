<?php

namespace Erupt\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Erupt\Application;
use Erupt\Language\EruptLang;

class EruptMakeCommand extends GeneratorCommand
{
    protected $signature = 'erupt:make {model*} {--file=*} {--template=*} {--generator=*}';

    protected $description = 'make a laravel component';

    public function __construct(Filesystem $files, Application $app)
    {
        parent::__construct($files);

        $this->app = $app;
    }

    public function handle()
    {
        $model = $this->argument("model");

        $file = $this->option("file");

        $template = $this->option("template");

        $path = $this->get_path($file["path"], $file["class_name"]);

        $this->makeDirectory($path);

        $this->files->put($path, $this->build($model, $file));

        $this->info(' created successfully.');
    }

    protected function get_path($path, $name): string
    {
        return trim($path, "/\\")."/".$name.".php";
    }

    protected function build($model, $file)
    {
        $template = $this->make_template($this->files->get($this->getStub()));

        $updated_template = $this->update_use($template);

        $data_json = $this->get_data($updated_template);

        $template = $this->get_template($updated_template);

        /*
        $events = $json["events"];

        foreach($events as $event) {
            $this->app->dispatch($event);
        }
        */

        $model = $this->argument("model");

        $op_template = $this->option("template");

        $type = lcfirst($op_template["key"]);

        $eruptLang = new EruptLang($this->app);

        return $eruptLang->exec($template, $model["name"], $type);
    }

    protected function getStub()
    {
        $model = $this->argument("model");
        $template = $this->option("template");

        $base_path = trim($template["base_path"], "/\\");
        $model_type = trim($model["type"], "/\\");
        $template_name = trim($template["name"], "/\\");

        return "/$base_path/models/$model_type/$template_name.txt";
    }

    protected function make_template(string $component): string
    {
        $nested_components = $this->get_nested_components($component);

        foreach($nested_components as $name => $text) {
            $component = $this->update_component($component, $name, $text);
        }

        return $component;
    }

    protected function get_nested_components(string $component): array
    {
        $data_json = $this->get_data($component);

        $component_names = $data_json["components"];

        $result = [];

        foreach($component_names as $name) {
            $result[$name] = $this->get_component($name);
        }

        return $result;
    }

    protected function get_data(string $component): array
    {
        $data_pattern = "/<data>(.*)<\/data>/s";

        if(preg_match($data_pattern, $component, $matches)) {
            return $this->init_data(trim($matches[1]));
        } else {
            return $this->init_data("{}");
        }
    }

    protected function init_data(string $data): array
    {
        return array_merge(
            [
                "use" => [],
                "components" => [],
                "events" => [],
            ],
            json_decode($data, true)
        );
    }

    //  "methods/controller/index"
    protected function get_component($component_name)
    {
        $model = $this->argument("model");
        $template = $this->option("template");

        $base_path = trim($template["base_path"], "/\\");

        return $this->files->get("/$base_path/components/$component_name.txt");
    }

    protected function update_component(string $comp, string $nc_name, string $nc_text): string
    {
        $nu_component = $this->make_template($nc_text);

        $template = $this->merge_template(
            $this->get_template($comp),
            $this->get_template($nu_component),
            $nc_name,
        );

        $data = $this->merge_data(
            $this->get_data($comp),
            $this->get_data($nu_component),
        );

        return $this->make_component($template, json_encode($data));
    }

    protected function get_template(string $component): string
    {
        $data_pattern = "/<data>(.*)<\/data>/s";

        return preg_replace($data_pattern, '', $component);
    }

    protected function merge_template(string $parent, string $child, string $child_name): string
    {
        return str_replace("@$child_name", trim($child), $parent);
    }

    protected function merge_data(array $parent, array $child): array
    {
        $targets = [
            "use",
            "events",
        ];

        foreach($targets as $target) {
            $parent[$target] = array_merge($parent["use"], $child["use"]);
        }

        return $parent;
    }

    protected function make_component(string $template, string $data): string
    {
        return "$template<data>$data</data>";
    }

    protected function update_use(string $template): string
    {
        $data_json = $this->get_data($template);

        $uses = array_map(function ($n) {
            return "use $n;";
        }, $data_json["use"]);

        $uses = implode("\n", $uses);

        return str_replace("@use", $uses, $template);
    }
}