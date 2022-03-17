<?php

namespace Erupt\Routes;

use Erupt\Foundation\BaseListItem;

abstract class BaseRoute extends BaseListItem
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
        return "Erupt\\Routes\\Items\\".strtoupper($name)."\\Route";
    }

    protected static function makeInstance(string $className): self
    {
        if(class_exists($className)) {
            $product = new $className;
        } else {
            $product = new \Erupt\Routes\Items\Unknown\Route;
        }
    }

    public function get(): string
    {
        return $this->name;
    }
}