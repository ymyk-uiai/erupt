<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\HiddenAttribute;

class HiddenAttributeConstructor
{
    public static function build(): HiddenAttribute
    {
        $attribute = new HiddenAttribute;

        return $attribute;
    }
}