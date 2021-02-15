<?php

namespace Erupt\Models\ValidationRules\Lists;

use Erupt\Models\ValidationRules\BaseValidationRuleList;

class ValidationRuleList extends BaseValidationRuleList
{
    public static function build(): Self
    {
        $validation_rules = new Self;

        return $validation_rules;
    }
}