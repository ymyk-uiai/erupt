<?php

namespace Erupt\Files;

use Erupt\Foundation\BaseListItem;
use Erupt\Models\BaseModel;

abstract class BaseFile extends BaseListItem
{
    public static function isTarget($subject): bool
    {
        foreach(static::$targets as $target) {
            if($subject instanceof $target) {
                return true;
            }
        }
        return false;
    }

    public static function make($subject, $app): self
    {
        return new static($app);
    }

    public function __construct($app)
    {
        $this->app = $app;
    }

    abstract public function getPath(): string;

    abstract public function getName(): string;

    public function getCorrespondingModel(): BaseModel
    {
        $modelName = $this->name;

        return $this->app->getModels()->get($modelName);
    }

    public function getTemplateAndData(): array
    {
        $component = $this->getComponent();

        $template = $this->cropTemplate($component);
        $data = $this->cropData($component);

        return [$template, $data];
    }

    protected function getComponent(): string
    {
        $component = $this->getTopComponent();

        return $this->mergeComponents(
            $component,
            $this->getNestedComponents($component),
        );
    }

    abstract protected function getTopComponent(): string;

    protected function getBaseComponentPath(): string
    {
        return __DIR__."/components";
    }

    protected function getNestedComponents(string $component): array
    {
        $components = [];

        $data = $this->cropData($component);

        foreach($data["components"] as $c) {
            $components[$c] = $this->getNestedComponent(__DIR__."/components/".$c.".txt");
        }

        return $components;
    }

    protected function getNestedComponent(string $component): string
    {
        $component = file_get_contents($component);

        return $this->mergeComponents(
            $component,
            $this->getNestedComponents($component),
        );
    }

    protected function mergeComponents(string $component, array $comps): string
    {
        foreach($comps as $name => $value) {
            $component = $this->mergeTemplate($component, $name, $value);
            $data = $this->mergeData($component, $value);

            $component = $this->cropTemplate($component) ."<data>". json_encode($data) . "</data>";
        }
        return $component;
    }

    protected function mergeTemplate(string $comp, string $name, string $value): string
    {
        return str_replace("@$name", $this->cropTemplate($value), $comp);
    }

    protected function mergeData(string $parent, string $child): array
    {
        $targets = [
            "use",
            "events",
        ];

        $parent = $this->cropData($parent);
        $child = $this->cropData($child);

        foreach($targets as $target) {
            $parent[$target] = array_merge($parent[$target], $child[$target]);
        }

        return $parent;
    }

    protected function cropTemplate(string $component): string
    {
        return preg_replace("/<data>(.*)<\/data>/s", '', $component);
    }

    protected function cropData(string $component): array
    {
        $data_pattern = "/<data>(.*)<\/data>/s";

        //print_r("cropData\n\$component\n$component\n");

        if(preg_match($data_pattern, $component, $matches)) {
            return $this->initData(trim($matches[1]));
        } else {
            return $this->initData("{}");
        }
    }

    protected function initData(string $data): array
    {
        //print_r("initData\n\$component\n$data\n");
        return array_merge(
            [
                "use" => [],
                "components" => [],
                "events" => [],
            ],
            json_decode($data, true)
        );
    }
}