<?php

namespace Erupt\ValidationRules\Items\Test;

use Erupt\ValidationRules\BaseValidationRule;

class ValidationRule extends BaseValidationRule
{
    protected string $params = "arg1,arg2";

    public function __construct()
    {
        //
    }
}