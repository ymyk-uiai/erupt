<?php

namespace Erupt\Plans\Constructors\Lists\Properties;

use Erupt\Plans\Lists\Properties\PropertyList;
use Erupt\Plans\Properties\Property;

class PropertyListConstructor
{
    public static function build($plans): PropertyList
    {
        $propertyList = new PropertyList;

        foreach($plans as $plan) {
            $property = Property::build($plan);

            $propertyList->add($property);
        }

        return $propertyList;
    }
}