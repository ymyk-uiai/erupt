<?php

namespace Erupt\Models\Constructors\Models;

use Erupt\Models\Models\Auth as Product;

class Auth
{
    protected static $type = "auth";

    public static function build($name): Product
    {
        $product = new Product;

        $product->setName($name);

        return $product;
    }
}