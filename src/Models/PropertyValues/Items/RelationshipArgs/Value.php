<?php

namespace Erupt\Models\PropertyValues\Items\RelationshipArgs;

use Erupt\Models\PropertyValues\BasePropertyValue;

class Value extends BasePropertyValue
{
    public function getKey(): string
    {
        return "relationshipArgs";
    }
}