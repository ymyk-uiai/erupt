<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\UnsignedBigIntegerUpdater as Product;

class UnsignedBigIntegerUpdater
{
    public static function build($args): Product
    {
        $product = new Product;

        $product->setName($args["name"]);

        return $product;
    }
}