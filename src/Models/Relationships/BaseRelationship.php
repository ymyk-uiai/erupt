<?php

namespace Erupt\Models\Relationships;

use Erupt\Foundations\Lists\BaseListItem;

abstract class BaseRelationship extends BaseListItem
{
    protected string $name;

    protected bool $is_owner;

    protected array $flags = [];

    public function set_name(string $name)
    {
        $this->name = $name;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function set_is_owner(bool $bool)
    {
        $this->is_owner = $bool;
    }

    public function get_is_owner(): bool
    {
        return $this->is_owner;
    }

    public function set_flag(string $flag_name)
    {
        $this->flags[$flag_name] = true;
    }

    public function get_flag(string $flag_name): bool
    {
        if(array_key_exists($flag_name, $this->flags)) {
            return $this->flags[$flag_name];
        } else {
            return false;
        }
    }
}