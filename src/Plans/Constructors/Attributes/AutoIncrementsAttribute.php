<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\AutoIncrementsAttribute as Product;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class AutoIncrementsAttribute extends AbstractAttributeConstructor
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}