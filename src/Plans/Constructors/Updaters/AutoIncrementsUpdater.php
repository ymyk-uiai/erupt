<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\AutoIncrementsUpdater as Product;

class AutoIncrementsUpdater
{
    public static function build($args): Product
    {
        $product = new Product;

        return $product;
    }
}