<?php

namespace Erupt\Attributes\Containers;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\Property;

class AttributeContainer extends BaseAttributeContainer
{
    protected static function getCorrespondingPropertyName(): string
    {
        return "Property";
    }
}