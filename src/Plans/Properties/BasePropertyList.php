<?php

namespace Erupt\Plans\Properties;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Plans\Properties\Items\Property;
use Erupt\Plans\Properties\Items\RelationshipProperty;

abstract class BasePropertyList extends BaseList
{
    public static function build($data): Self
    {
        $product = new Static;

        foreach($data["plans"] as $plan) {
            $property = Property::build($plan);

            $product->add($property);
        }

        foreach($data["relationshipPlans"] as $relationshipPlan) {
            $relationshipProperty = RelationshipProperty::build($relationshipPlan);

            $product->add($relationshipProperty);
        }

        return $product;
    }
    
    //  Unit Type BasePropety|BasePropertyList
    public function add($property)
    {
        parent::add($property);
    }
}