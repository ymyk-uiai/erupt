<?php

namespace Erupt\Models\ValidationRules\Items\Nullable;

use Erupt\Models\ValidationRules\BaseValidationRule;
use Erupt\Traits\HasParams;

class Rule extends BaseValidationRule
{
    use HasParams;

    protected string $params = "";
}