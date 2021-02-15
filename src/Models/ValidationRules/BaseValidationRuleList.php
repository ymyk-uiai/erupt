<?php

namespace Erupt\Models\ValidationRules;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Models\ValidationRules\BaseValidationRule;

abstract class BaseValidationRuleList extends BaseList
{
    //  BaseValidationRule|Self
    public function add($validation_rule)
    {
        parent::add($validation_rule);
    }

    //  BaseValidationRule|Self
    public function remove($validation_rule)
    {
        parent::remove($validation_rule);
    }
}