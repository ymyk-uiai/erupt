<?php

namespace Erupt\Values;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;
use Erupt\Attributes\BaseAttribute as Attribute;

abstract class BaseValue extends BaseListItem
{
    use HasParams;

    protected string $params = "";

    public static function build(string $value, Attribute $setter = null): self
    {
        list($name, $args) = explode(":", $value.":", 2);

        $className = "Erupt\\Values\\Items\\".strtoupper($name)."\\Value";

        if(class_exists($className)) {
            $product = new $className;
        } else {
            $product = new \Erupt\Values\Items\Unknown\Value;
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