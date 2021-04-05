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

    protected function init_flags(): void
    {
        $default_flags = [
            "has" => false,
            "belongs" => false,
            "morphHas" => false,
            "morphBelongs" => false,
        ];

        foreach($default_flags as $key => $value) {
            $this->set_flag($key, $value);
        }
    }

    public function set_flag(string $key, bool $bool): void
    {
        $this->flags[$key] = $bool;
    }

    public function get_flag(string $key): bool
    {
        return array_key_exists($key, $this->flags) ? $this->flags[$key] : false;
    }

    public function get_impl_method_name(): string
    {
        return match($this->is_owner) {
            true => $this->app->get_model($this->name)->get_name()."s",
            false => $this->app->get_model($this->name)->get_name(),
        };
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

        return match($key) {
            "model" => $this->app->get_model($this->name)->resolve($keys),
            "name" => $this->name,
            "r_method_name" => $this->get_impl_method_name(),
            "r_method" => $this->get_r_method(),
            "r_method_args" => $this->get_r_method_args(),
            default => "unknown resolve key",
        };
    }
}