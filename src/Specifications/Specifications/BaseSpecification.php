<?php

namespace Erupt\Specifications\Specifications;

use Erupt\Foundations\BaseItem;
use Erupt\Foundations\ResolverItem;
use Erupt\Interfaces\Resolver;
use Erupt\Specifications\Value;

abstract class BaseSpecification extends ResolverItem
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

    abstract public function get_args_and_options($t, $r): array;

    protected function getResolver(string $key, array &$keys): Resolver
    {
        return match($key) {
            "short_name" => new Value($this->data["data_short_name"]),
            "class_name" => new Value($this->data["data_class_name"]),
            "namespace" => new Value($this->data["data_namespace"]),
            "model_name" => new Value($this->data["model_name"]),
            "spec_variant" => new Value($this->data["data_spec_variant"]),
            "use_as" => new Value($this->data["data_use_as"]),
            "full_use_as" => new Value($this->data["data_class_name"]),
            "instance" => new Value($this->data["model_name"]),
            "instances" => new Value($this->data["model_name"]."s"),
        };
    }

    public function evaluate()
    {
        return $this;
    }
}