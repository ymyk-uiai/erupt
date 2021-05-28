<?php

namespace Erupt\Traits;

use Erupt\Models\Values\Lists\PropertyValueList;

trait HasPropertyValues
{
    protected PropertyValueList $propertyValues;

    public function setPropertyValueList(PropertyValueList $propertyValues): void
    {
        $this->propertyValues = $propertyValues;
    }

    public function getPropertyValueList(): PropertyValueList
    {
        return $this->propertyValues;
    }
}