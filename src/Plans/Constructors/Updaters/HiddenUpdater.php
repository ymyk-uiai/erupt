<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\HiddenUpdater as Product;

class HiddenUpdater
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}