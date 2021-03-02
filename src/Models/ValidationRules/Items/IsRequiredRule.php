<?php

namespace Erupt\Models\ValidationRules\Items;

use Erupt\Models\ValidationRules\BaseValidationRule;

class IsRequiredRule extends BaseValidationRule
{
    protected string $name;

    public static function build(bool $is_required): Self
    {
        $product = new Self;

        $product->set_name($is_required);

        return $product;
    }

    public function set_name(bool $is_required)
    {
        $this->name = $is_required ? "required" : "nullable";
    }
}