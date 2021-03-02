<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Foundations\Lists\BaseListItem;

abstract class BaseRelationship extends BaseListItem
{
    protected string $name;

    protected array $flags;

    abstract public function get_model_relationships($model, $relationships, $app);

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_flag(string $flag_key): bool
    {
        if(array_key_exists($flag_key, $this->flags)) {
            return $this->flags[$flag_key];
        } else {
            return false;
        }
    }
}