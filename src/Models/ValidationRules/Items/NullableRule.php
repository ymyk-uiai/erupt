<?php

namespace Erupt\Models\ValidationRules\Items;

use Erupt\Models\ValidationRules\BaseValidationRule;

class NullableRule extends BaseValidationRule
{
    protected string $name = "nullable";

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