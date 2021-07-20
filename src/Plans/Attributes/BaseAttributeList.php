<?php

namespace Erupt\Plans\Attributes;

use Erupt\Foundations\BaseList;
use Erupt\Models\Properties\BaseProperty as ModelProp;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Interfaces\SchemaDummyCommand;

abstract class BaseAttributeList extends BaseList
{
    public function __construct(string $attrs = "")
    {
        $attrs = $this->parseAttributes($attrs);

        foreach($attrs as $attr) {
            $namespace = 'Erupt\Plans\Attributes\Items';
            $className = $namespace.'\\'.$attr['className'].'\Attribute';
            if(class_exists($className)) {
                $this->add(new $className($attr['args']));
            } else {
                //print_r("$className\n");
                $this->add(new Items\Flag\Attribute($attr['name']));
            }
        }
    }

    protected function parseAttributes(string $attrs): array
    {
        $attributes = [];

        foreach(array_filter(explode('|', $attrs)) as $attr) {
            $attributes[] = $this->parseAttribute($attr);
        }

        return $attributes;
    }

    protected function parseAttribute(string $attr): array
    {
        $exploded = explode(':', $attr);

        return [
            "name" => $exploded[0],
            "className" => ucfirst($exploded[0]),
            "args" => $exploded[1] ?? "",
        ];
    }

    public function isCommand(): bool
    {
        foreach($this->list as $item) {
            if($item instanceof SchemaCommand || $item instanceof SchemaDummyCommand) {
                return true;
            }
        }

        return false;
    }

    public function isCommandStrict(): bool
    {
        foreach($this->list as $item) {
            if($item instanceof SchemaCommand) {
                return true;
            }
        }

        return false;
    }

    abstract protected function makeCorrespondingModelProp($app, $model): ModelProp;

    public function makeModelProp($app, $model): ModelProp
    {
        $product = $this->makeCorrespondingModelProp($app, $model);

        foreach($this->list as $attr) {
            foreach($attr->getBuilders() as $bldr) {
                $builder = new $bldr[0]($app, $model, $product);
                $builder->build($bldr[1] ?? "");
                $product->build($builder);
            }
        }

        $product->complete();
    
        return $product;
    }

    //  $attrItemOrList
    public function add(BaseAttribute|Self $plan): void
    {
        $this->addItemOrList($plan);
    }

    public function remove(BaseAttribute|Self $plan): void
    {
        $this->removeItemOrList($plan);
    }
}