<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\TimestampUpdater as Product;

class TimestampUpdater
{
    public static function build($args): Product
    {
        $product = new Product;

        $product->setName($args["name"]);

        $product->setPrecision($args["precision"]);

        return $product;
    }
}