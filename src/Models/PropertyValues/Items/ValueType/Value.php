<?php

namespace Erupt\Models\PropertyValues\Items\ValueType;

use Erupt\Models\PropertyValues\BasePropertyValue;

class Value extends BasePropertyValue
{
    public function getKey(): string
    {
        return "valueType";
    }
}