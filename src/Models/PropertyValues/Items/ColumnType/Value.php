<?php

namespace Erupt\Models\PropertyValues\Items\ColumnType;

use Erupt\Models\PropertyValues\BasePropertyValue;

class Value extends BasePropertyValue
{
    public function getKey(): string
    {
        return "columnType";
    }
}