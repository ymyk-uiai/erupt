<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\CastsUpdater as Product;

class CastsUpdater
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}