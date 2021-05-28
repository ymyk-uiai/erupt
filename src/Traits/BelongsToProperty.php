<?php

namespace Erupt\Traits;

use Erupt\Models\Properties\BaseProperty as Property;

trait BelongsToProperty
{
    protected Property $property;

    public function setProperty(Property $property): void
    {
        $this->property = $property;
    }

    public function getProperty(): Property
    {
        return $this->property;
    }
}