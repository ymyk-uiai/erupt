<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\NullableUpdater as Product;

class NullableUpdater
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}