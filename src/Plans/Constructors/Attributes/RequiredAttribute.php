<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\RequiredAttribute as Product;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class RequiredAttribute extends AbstractAttributeConstructor
{
    public static function build(): Product
    {
        $product = new Product;

        return $product;
    }
}