<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\FillableUpdater as Product;

class FillableUpdater
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}