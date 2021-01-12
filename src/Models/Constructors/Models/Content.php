<?php

namespace Erupt\Models\Constructors\Models;

use Erupt\Models\Models\Content as Product;

class Content
{
    protected static $type = "content";

    public static function build($name): Product
    {
        $product = new Product;

        $product->setName($name);

        return $product;
    }
}