<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\IdAttribute;

class IdAttributeConstructor
{
    public static function build(): IdAttribute
    {
        $attribute = new IdAttribute;

        return $attribute;
    }
}