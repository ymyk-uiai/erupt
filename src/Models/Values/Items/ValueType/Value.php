<?php

namespace Erupt\Models\Values\Items\ValueType;

use Erupt\Models\Values\BaseValue;
use Erupt\Traits\HasParams;

class Value extends BaseValue
{
    public function getKey(): string
    {
        return "valueType";
    }
}