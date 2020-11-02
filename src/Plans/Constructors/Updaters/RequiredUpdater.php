<?php

namespace Erupt\Plans\Constructors\Updaters;

use Erupt\Plans\Updaters\RequiredUpdater as Product;

class RequiredUpdater
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}