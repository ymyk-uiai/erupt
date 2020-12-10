<?php

namespace Erupt\Abstracts\Models\Properties;

use Erupt\Abstracts\Foundations\BaseListItem;

class Property extends BaseListItem
{
    protected $name;

    protected $columnType;

    protected $valueType;

    protected string $factory = "";

    protected array $validationRules = [];

    protected array $flags = [];

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getColumnType()
    {
        return $this->columnType;
    }

    public function setColumnType($type)
    {
        $this->columnType = $type;
    }

    public function getValueTypee()
    {
        return $this->valueType;
    }

    public function setValueType($type)
    {
        $this->valueType = $type;
    }

    public function getFactory(): string
    {
        return $this->factory;
    }

    public function setFactory(string $factory)
    {
        $this->factory = $factory;
    }

    public function getFlag(string $key): bool
    {
        return array_key_exists($key, $this->flags) ? $this->flags[$key] : false;
    }

    public function setFlag(string $key, bool $bool)
    {
        $this->flags[$key] = $bool;
    }

    public function getValidationRules(string $key): bool
    {
        return array_key_exists($key, $this->validationRules) ? $this->validationRules[$key] : false;
    }

    public function setValidationRules(string $key, string $args = null)
    {
        $this->validationRules[$key] = $args;
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
            "columnType",
            "valueType",
            "factory",
            "validationRules",
        ];

        if(in_array($key, $props)) {
            return $this->{$key};
        }
    }
}