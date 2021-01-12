<?php

namespace Erupt\Models\Constructors\Models;

use Erupt\Models\Models\Binder as Product;

class Binder
{
    protected static $type = "binder";

    public static function build($name): Product
    {
        $product = new Product;

        $product->setName($name);

        return $product;
    }
}