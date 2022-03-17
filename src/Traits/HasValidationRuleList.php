<?php

namespace Erupt\Traits;

use Erupt\ValidationRules\Lists\ValidationRuleList;

trait HasValidationRuleList
{
    protected ValidationRuleList $validationRules;

    public function initValidationRuleList(): void
    {
        $this->validationRules = new ValidationRuleList;
    }

    public function getValidationRuleList(): ValidationRuleList
    {
        return $this->validationRules;
    }
}