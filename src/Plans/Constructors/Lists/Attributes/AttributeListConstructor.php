<?php

namespace Erupt\Plans\Constructors\Lists\Attributes;

use Erupt\Plans\Lists\Attributes\AttributeList;

class AttributeListConstructor
{
    public static function build($plan): AttributeList
    {
        $attributes = explode('&', $plan);

        $attributeList = new AttributeList;

        $ns = "Erupt\\Plans\\Attributes";

        foreach($attributes as $attribute) {
            $exploded = explode(':', $attribute);

            $cn = "{$ns}\\".ucfirst($exploded[0])."Attribute";

            $args = array_key_exists(1, $exploded) ? $exploded[1] : "";

            $a = $cn::build($args);

            $attributeList->add($a);
        }

        return $attributeList;
    }
}