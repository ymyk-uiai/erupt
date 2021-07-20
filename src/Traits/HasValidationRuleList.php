<?php

namespace Erupt\Traits;

use Erupt\Models\ValidationRules\BaseValidationRuleList as ValidationRuleList;

trait HasValidationRuleList
{
    protected ValidationRuleList $validationRules;

    public function setValidationRules(ValidationRuleList $validationRules): void
    {
        $this->validationRules = $validationRules;
    }

    public function getValidationRules(): ValidationRuleList
    {
        return $this->validationRules;
    }
}