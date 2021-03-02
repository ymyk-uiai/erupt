<?php

namespace Erupt\Models\ValidationRules\Lists;

use Erupt\Models\ValidationRules\BaseValidationRuleList;
use Erupt\Models\ValidationRules\BaseValidationRule;

class ValidationRuleList extends BaseValidationRuleList
{
    public static function build(): Self
    {
        $validation_rules = new Self;

        return $validation_rules;
    }

    public function add($validation_rule)
    {
        foreach($this as $rule) {
            if(get_class($rule) == get_class($validation_rule)) {
                $this->remove($rule);
            }
        }

        parent::add($validation_rule);
    }
}