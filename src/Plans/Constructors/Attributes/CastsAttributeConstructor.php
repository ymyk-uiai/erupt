<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\CastsAttribute;

class CastsAttributeConstructor
{
    public static function build(): CastsAttribute
    {
        $attribute = new CastsAttribute;

        return $attribute;
    }
}