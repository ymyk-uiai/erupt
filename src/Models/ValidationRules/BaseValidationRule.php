<?php

namespace Erupt\Models\ValidationRules;

use Erupt\Foundations\Lists\BaseListItem;

abstract class BaseValidationRule extends BaseListItem
{
    protected array $args = [];

    public function resolve($keys)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        if(empty($keys)) {
            return $this;
        }

        $key = array_shift($keys);

        $props = [
            "name",
            "args",
        ];

        if(in_array($key, $props)) {
            return $this->{$key};
        }
    }
}