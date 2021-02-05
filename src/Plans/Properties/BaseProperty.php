<?php

namespace Erupt\Plans\Properties;

use Erupt\Foundations\Lists\BaseListItem;
use Erupt\Plans\Methods\Lists\AttributeList;

abstract class BaseProperty extends BaseListItem
{
    protected AttributeList $attributes;

    public static function build($plan): Self
    {
        $property = new Static;

        $property->set_attributes(AttributeList::build($plan));

        return $property;
    }

    public function get_attributes(): AttributeList
    {
        return $this->attributes;
    }

    public function set_attributes(AttributeList $attributes)
    {
        $this->attributes = $attributes;
    }
}