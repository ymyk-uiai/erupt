<?php

namespace Erupt\Seeders;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;

abstract class BaseSeeder extends BaseListItem
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
        return "Erupt\\Seeders\\Items\\".strtoupper($name)."\\Seeder";
    }

    protected static function makeInstance(string $className): self
    {
        if(class_exists($className)) {
            $product = new $className;
        } else {
            $product = new \Erupt\Seeders\Items\Unknown\Seeder;
        }
    }

    public function get(): string
    {
        return $this->name;
    }
}