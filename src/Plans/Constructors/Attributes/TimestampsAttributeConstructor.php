<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\TimestampsAttribute as Product;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class TimestampsAttributeConstructor extends AbstractAttributeConstructor
{
    public static function build($args): Product
    {
        $product = new Product;

        $params = Self::parseParams("precision?", $args);

        $product->setPrecision($params["precision"]);

        return $product;
    }
}