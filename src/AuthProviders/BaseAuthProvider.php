<?php

namespace Erupt\AuthProviders;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;

abstract class BaseAuthProvider extends BaseListItem
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

    protected static function makeClassName(string $name): string
    {
        return "Erupt\\AuthProviders\\Items\\".strtoupper($name)."\\AuthProvider";
    }

    protected static function makeInstance(string $className): self
    {
        if(class_exists($className)) {
            $product = new $className;
        } else {
            $product = new \Erupt\AuthProviders\Items\Unknown\AuthProvider;
        }
    }

    public function get(): string
    {
        return $this->name;
    }
}