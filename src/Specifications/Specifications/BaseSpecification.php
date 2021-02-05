<?php

namespace Erupt\Specifications\Specifications;

use Erupt\Foundations\Lists\BaseListItem;

abstract class BaseSpecification extends BaseListItem
{
    protected string $name;

    protected bool $is_owner;

    protected array $flags;

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

    public function get_flag(string $flag_key): bool
    {
        if(array_key_exists($flag_key, $this->flags)) {
            return $this->flags[$flag_key];
        } else {
            return false;
        }
    }

    abstract public function get_args_and_options(): array;
}