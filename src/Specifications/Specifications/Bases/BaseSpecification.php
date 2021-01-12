<?php

namespace Erupt\Specifications\Specifications\Bases;

use Erupt\Abstracts\Foundations\BaseListItem;

class BaseSpecification extends BaseListItem
{

    public function set_name(string $name)
    {
        $this->name = $name;
    }

    public function set_is_owner(bool $bool)
    {
        $this->is_owner = $bool;
    }

    public function set_flag(string $flag_name)
    {
        $this->flags[$flag_name] = true;
    }

    public function getFlag(string $flagKey): bool
    {
        if(array_key_exists($flagKey, $this->flags)) {
            return $this->flags[$flagKey];
        } else {
            return false;
        }
    }
}