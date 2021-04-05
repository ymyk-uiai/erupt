<?php

namespace Erupt\Plans\Properties;

use Erupt\Foundations\Lists\BaseListItem;
use Erupt\Plans\Methods\Lists\AttributeList;
use Erupt\Interfaces\SchemaMethod;
use Erupt\Models\SchemaMethods\Lists\SchemaMethodList;

abstract class BaseProperty extends BaseListItem
{
    protected AttributeList $attributes;

    public static function build($plan): Self
    {
        $property = new Static;

        $property->set_attributes(AttributeList::build($plan));

        return $property;
    }

    public function get_method(): string
    {
        $method = "";

        foreach($this->attributes as $attribute) {
            if($attribute instanceof SchemaMethod) {
                $method .= $attribute->get_schema_method();
            }
        }

        return $method;
    }

    public function get_methods()
    {
        $methods = new SchemaMethodList;

        foreach($this->attributes as $attribute) {
            if($attribute instanceof SchemaMethod) {
                $methods->add($attribute->get_schema_method_2());
            }
        }

        return $methods;
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