<?php

namespace Erupt\Models\PropertyValues\Items\RelationshipMethodName;

use Erupt\Models\PropertyValues\BasePropertyValue;

class Value extends BasePropertyValue
{
    public function getKey(): string
    {
        return "relationshipMethodName";
    }
}