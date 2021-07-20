<?php

namespace Erupt\Models\PropertyValues\Items\Name;

use Erupt\Models\PropertyValues\BasePropertyValue;

class Value extends BasePropertyValue
{
    public function getKey(): string
    {
        return "name";
    }
}