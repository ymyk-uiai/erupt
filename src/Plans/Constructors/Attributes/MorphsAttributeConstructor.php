<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\MorphsAttribute;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class MorphsAttributeConstructor extends AbstractAttributeConstructor
{
    public static function build($args): MorphsAttribute
    {
        $attribute = new MorphsAttribute;

        $params = Self::parseParams("name", $args);

        $attribute->setName($params["name"]);

        return $attribute;
    }
}