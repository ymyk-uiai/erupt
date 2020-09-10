<?php

namespace Erupt\Plans\Constructors\Attributes;

use Erupt\Plans\Attributes\ForeignIdAttribute;
use Erupt\Abstracts\Constructors\Plans\Attributes\Attribute as AbstractAttributeConstructor;

class ForeignIdAttributeConstructor extends AbstractAttributeConstructor
{
    public static function build($args): ForeignIdAttribute
    {
        $attribute = new ForeignIdAttribute;

        $params = Self::parseParams("name", $args);

        $attribute->setName($params["name"]);

        return $attribute;
    }
}