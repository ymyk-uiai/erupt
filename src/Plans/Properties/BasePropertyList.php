<?php

namespace Erupt\Plans\Properties;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Plans\Properties\Items\Property;

abstract class BasePropertyList extends BaseList
{
    public static function build($plans): Self
    {
        $product = new Static;

        foreach($plans as $plan) {
            $property = Property::build($plan);

            $product->add($property);
        }

        return $product;
    }
    
    //  Unit Type BasePropety|BasePropertyList
    public function add($property)
    {
        parent::add($property);
    }
}