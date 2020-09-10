<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\FillableAttribute;

class FillableAttributeConstructor
{
    public static function build(): FillableAttribute
    {
        $attribute = new FillableAttribute;

        return $attribute;
    }
}