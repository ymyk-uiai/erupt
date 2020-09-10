<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\UnsignedBigIntegerAttribute as Product;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class UnsignedBigIntegerAttribute extends AbstractAttributeConstructor
{
    public static function build($args): Product
    {
        $product = new Product;

        $params = Self::parseParams("name", $args);

        $product->setName($params["name"]);

        return $product;
    }
}