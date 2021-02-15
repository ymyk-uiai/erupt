<?php

namespace Erupt\Models\ValidationRules\Items;

use Erupt\Models\ValidationRules\BaseValidationRule;

class RequiredRule extends BaseValidationRule
{
    protected string $name = "required";

    public static function build(): Self
    {
        $product = new Self;

        return $product;
    }

    public function get_name(): string
    {
        return $this->name;
    }
}