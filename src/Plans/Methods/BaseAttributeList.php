<?php

namespace Erupt\Plans\Methods;

use Erupt\Foundations\Lists\BaseList;

abstract class BaseAttributeList extends BaseList
{
    public static function build($plan): Self
    {
        $attributes = explode('&', $plan);

        $attributeList = new Static;

        $ns = "Erupt\\Plans\\Methods\\Items";

        foreach($attributes as $attribute) {
            $exploded = explode(':', $attribute);

            $cn = "{$ns}\\".ucfirst($exploded[0])."\\Attribute";

            $args = array_key_exists(1, $exploded) ? $exploded[1] : "";

            $a = $cn::build($args);

            $attributeList->add($a);
        }

        return $attributeList;
    }

    //  Unit Type BaseAttribute|BaseAttributeList
    public function add($attribute)
    {
        parent::add($attribute);
    }
}