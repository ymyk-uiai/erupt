<?php

namespace Erupt\Models\Constructors\Models;

use Erupt\Models\Models\Response as Product;

class Response
{
    public static function build($name): Product
    {
        $product = new Product;

        $product->setName($name);

        return $product;
    }
}