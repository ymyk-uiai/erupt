<?php

namespace Erupt\Flags;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;
use Erupt\Attributes\BaseAttribute as Attribute;

abstract class BaseFlag extends BaseListItem
{
    use HasParams;

    protected string $params = "";

    public static function build(string $value, Attribute $setter = null): self
    {
        list($name, $args) = explode(":", $value.":", 2);

        $className = "Erupt\\Flags\\Items\\".strtoupper($name)."\\Flag";

        if(class_exists($className)) {
            $product = new $className;
        } else {
            $product = new \Erupt\Flags\Items\Unknown\Flag;
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