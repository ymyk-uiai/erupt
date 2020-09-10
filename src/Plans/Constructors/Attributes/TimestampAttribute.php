<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\TimestampAttribute as Product;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class TimestampAttribute extends AbstractAttributeConstructor
{
    public static function build($args): Product
    {
        $product = new Product;

        $params = Self::parseParams("name, precision?", $args);

        $product->setName($params["name"]);

        $product->setPrecision($params["precision"]);

        return $product;
    }
}