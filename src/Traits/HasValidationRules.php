<?php

namespace Erupt\Traits;

use Erupt\Models\ValidationRules\Lists\ValidationRuleList;

trait HasValidationRules
{
    protected ValidationRuleList $validationRules;

    public function setValidationRuleList(ValidationRuleList $validationRules): void
    {
        $this->validationRules = $validationRules;
    }

    public function getValidationRuleList(): ValidationRuleList
    {
        return $this->validationRules;
    }
}