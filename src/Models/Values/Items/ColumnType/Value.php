<?php

namespace Erupt\Models\Values\Items\ColumnType;

use Erupt\Models\Values\BaseValue;

class Value extends BaseValue
{
    public function getKey(): string
    {
        return "columnType";
    }
}