<?php

namespace Erupt\Plans\Properties;

use Erupt\Abstracts\Plans\Properties\Property as AbstractProperty;
use Erupt\Plans\Constructors\Properties\PropertyConstructor;
use Erupt\Plans\Lists\Attributes\AttributeList;

class Property extends AbstractProperty
{
    protected AttributeList $attributes;

    public function __construct()
    {
        //
    }

    public static function build($plan): Self
    {
        return PropertyConstructor::build($plan);
    }

    public function getAttributes(): AttributeList
    {
        return $this->attributes;
    }

    public function setAttributes(AttributeList $attributes)
    {
        $this->attributes = $attributes;
    }
}