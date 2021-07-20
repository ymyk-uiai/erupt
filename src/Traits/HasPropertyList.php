<?php

namespace Erupt\Traits;

use Erupt\Models\Properties\BasePropertyList as PropertyList;

trait HasPropertyList
{
    protected PropertyList $properties;

    public function setProperties(PropertyList $properties): void
    {
        $this->properties = $properties;
    }

    public function getProperties(): PropertyList
    {
        return $this->properties;
    }
}