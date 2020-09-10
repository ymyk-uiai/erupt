<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\BigIncrementsAttribute as Product;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class BigIncrementsAttribute extends AbstractAttributeConstructor
{
    public static function build($args): Product
    {
        $product = new Product;

        $params = Self::parseParams("name, length?", $args);

        $product->setName($params["name"]);

        return $product;
    }
}