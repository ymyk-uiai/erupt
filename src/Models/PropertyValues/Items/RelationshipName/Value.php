<?php

namespace Erupt\Models\PropertyValues\Items\RelationshipName;

use Erupt\Models\PropertyValues\BasePropertyValue;

class Value extends BasePropertyValue
{
    public function getKey(): string
    {
        return "relationshipName";
    }
}