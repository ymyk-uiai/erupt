<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Models\ValidationRules\Lists\ValidationRuleList;

class Property extends BaseProperty
{
    public static function build(): Self
    {
        $property = new Self;

        $property->set_validation_rules(ValidationRuleList::build());

        return $property;
    }
}