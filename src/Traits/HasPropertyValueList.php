<?php

namespace Erupt\Traits;

use Erupt\Models\PropertyValues\BasePropertyValueList as PropertyValueList;
use Erupt\Models\PropertyValues\BasePropertyValue as PropertyValue;

trait HasPropertyValueList
{
    protected PropertyValueList $values;

    public function setPropertyValues(PropertyValueList $propertyValues): void
    {
        $this->values = $propertyValues;
    }

    public function getPropertyValues(): PropertyValueList
    {
        return $this->values;
    }

    public function updatePropertyValues(PropertyValue $value): void
    {
        $this->values->add($value);
    }
}