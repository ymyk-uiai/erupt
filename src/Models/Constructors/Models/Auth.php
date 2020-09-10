<?php

namespace Erupt\Models\Constructors\Models;

use Erupt\Models\Models\Auth as Product;

class Auth
{
    public static function build($name): Product
    {
        $product = new Product;

        $product->setName($name);

        return $product;
    }
}