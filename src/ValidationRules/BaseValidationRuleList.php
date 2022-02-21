<?php

namespace Erupt\ValidationRules;

use Erupt\Foundation\BaseList;

abstract class BaseValidationRuleList extends BaseList
{
    public function add(BaseValidationRule|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseValidationRule|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}