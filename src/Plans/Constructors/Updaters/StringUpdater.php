<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\StringUpdater as Product;

class StringUpdater
{
    public static function build($args): Product
    {
        $product = new Product;

        $product->setName($args["name"]);

        $product->setLength($args["length"]);

        return $product;
    }
}