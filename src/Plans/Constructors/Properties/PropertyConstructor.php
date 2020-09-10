<?php

namespace Erupt\Plans\Constructors\Properties;

use Erupt\Plans\Properties\Property;
use Erupt\Plans\Lists\Attributes\AttributeList;

class PropertyConstructor
{
    public static function build($plan): Property
    {
        $property = new Property;

        $property->setAttributes(AttributeList::build($plan));

        return $property;
    }
}