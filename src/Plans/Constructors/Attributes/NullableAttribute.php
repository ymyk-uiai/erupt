<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\NullableAttribute as Product;

class NullableAttribute
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}