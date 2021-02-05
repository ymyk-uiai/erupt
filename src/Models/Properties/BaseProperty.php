<?php

namespace Erupt\Models\Properties;

use Erupt\Foundations\Lists\BaseListItem;

abstract class BaseProperty extends BaseListItem
{
    protected string $name;

    protected string $column_type;

    protected string $value_type;

    protected string $factory = "";

    protected array $validation_rules = [];

    protected array $flags = [];

    public function set_name(string $name)
    {
        $this->name = $name;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function set_column_type(string $column_type)
    {
        $this->column_type = $column_type;
    }

    public function get_column_type(): string
    {
        return $this->column_type;
    }

    public function set_value_type(string $value_type)
    {
        $this->value_type = $value_type;
    }

    public function get_value_type(): string
    {
        return $this->value_type;
    }

    public function set_factory(string $factory)
    {
        $this->factory = $factory;
    }

    public function get_factory(): string
    {
        return $this->factory;
    }

    public function set_flag(string $key, bool $bool)
    {
        $this->flags[$key] = $bool;
    }

    public function get_flag(string $key): bool
    {
        return array_key_exists($key, $this->flags) ? $this->flags[$key] : false;
    }

    public function set_validation_rules(array $validation_rules)
    {
        $this->validation_rules = $validation_rules;
    }

    public function get_validation_rules(): array
    {
        return $this->validation_rules;
    }

    public function set_validation_rule(string $key, string $args = null)
    {
        $this->validation_rules[$key] = $args;
    }

    public function get_validation_rule(string $rule)
    {
        return array_key_exists($key, $this->validation_rules)
            ? $this->validation_rules[$key]
            : false;
    }

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
            "column_type",
            "value_type",
            "factory",
            "validation_rules",
        ];

        if(in_array($key, $props)) {
            return $this->{$key};
        }
    }
}