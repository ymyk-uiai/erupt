<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Models\ValidationRules\Lists\ValidationRuleList;

class Property extends BaseProperty
{
    public static function build($app): Self
    {
        $property = new Self;

        $property->app = $app;

        $property->set_validation_rules(ValidationRuleList::build());

        return $property;
    }
}