<?php

namespace Erupt\Models\Relationships\Bases;

use Erupt\Abstracts\Foundations\BaseListItem;

class BaseRelationship extends BaseListItem
{
    protected string $name;

    protected bool $is_owner;

    protected array $flags = [];

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