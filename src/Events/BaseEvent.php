<?php

namespace Erupt\Events;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;

abstract class BaseEvent extends BaseListItem
{
    use HasParams;

    public static function build(string $ev): self
    {
        [$name, $args] = explode(":", "$ev:");

        return self::make($name, $args);
    }

    protected static function make(string $name, string $args): self
    {
        $className = self::makeClassName($name);

        $product = self::makeInstance($name);

        $product->takeArgs($args);

        return $product;
    }

    protected static function makeClassName(string $className): string
    {
        return "Erupt\\Events\\Items\\".strtoupper($name)."\\Event";
    }

    protected static function makeInstance(string $className): self
    {
        if(class_exists($className)) {
            $product = new $className;
        } else {
            $product = new \Erupt\Events\Items\Unknown\Event;
        }
    }

    abstract public function dispatch(): void;
}