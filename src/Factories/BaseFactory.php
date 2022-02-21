<?php

namespace Erupt\Factories;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;
use Erupt\Attributes\BaseAttribute as Attribute;

abstract class BaseFactory extends BaseListItem
{
    use HasParams;

    protected string $params = "";

    public static function build(string $value, Attribute $setter = null): self
    {
        list($name, $args) = explode(":", $value.":", 2);

        $className = "Erupt\\Factories\\Items\\".strtoupper($name)."\\Factory";

        if(class_exists($className)) {
            $product = new $className;
        } else {
            $product = new \Erupt\Factories\Items\Unknown\Factory;
        }

        if($setter) {
            $args = preg_replace_callback(
                "/({(\w+)})(.*)/",
                function ($matches) use ($setter) {
                    return $setter->getArg($matches[2]).$matches[3];
                },
                $args
            );
        }

        $product->takeArgs(trim($args, ":"));

        return $product;
    }
}