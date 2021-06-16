<?php

namespace Erupt\Models\Values\Items\Value;

use Erupt\Models\Values\BaseValue;

class Value extends BaseValue
{
    public function getKey(): string
    {
        return "value";
    }
}