<?php

namespace Erupt\Abstracts\Models\Properties;

use Erupt\Abstracts\Foundations\BaseListItem;

class Property extends BaseListItem
{
    protected $name;

    protected $columnType;

    protected $valueType;

    protected bool $fillable = false;

    protected bool $hidden = false;

    protected bool $casts = false;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setColumnType($type)
    {
        $this->columnType = $type;
    }

    public function setValueType($type)
    {
        $this->valueType = $type;
    }

    public function setFillable($bool)
    {
        $this->fillable = $bool;
    }

    public function setHidden($bool)
    {
        $this->hidden = $bool;
    }

    public function setNullable($bool)
    {
        $this->nulllable = $bool;
    }

    public function setCasts($type)
    {
        $this->casts = $type;
    }

    public function check($key)
    {
        $flags = [
            "fillable",
            "hidden",
            "casts",
        ];

        if(in_array($key, $flags)) {
            return $this->{$key};
        }
    }

    public function resolve($keys)
    {
        print_r("Property->resolve\n");

        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        print_r(implode('.', $keys)."\n");

        if(empty($keys)) {
            return $this;
        }

        $key = array_shift($keys);

        $props = [
            "name",
            "columnType",
            "valueType",
        ];

        if(in_array($key, $props)) {
            return $this->{$key};
        }
    }
}