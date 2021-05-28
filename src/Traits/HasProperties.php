<?php

namespace Erupt\Traits;

use Erupt\Models\Properties\Lists\PropertyList;

trait HasProperties
{
    protected PropertyList $properties;

    public function setPropertyList(PropertyList $properties): void
    {
        $this->properties = $properties;
    }

    public function getPropertyList(): PropertyList
    {
        return $this->properties;
    }
}