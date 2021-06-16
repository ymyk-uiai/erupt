<?php

namespace Erupt\Relationships\Members;

use Erupt\Relationships\Attributes\Lists\AttributeList;

abstract class BaseMember
{
    protected string $type;

    protected AttributeList $attributes;

    public function __construct(string $type, AttributeList $attrs)
    {
        $this->setType($type);

        $this->setAttributes($attrs);
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setAttributes(AttributeList $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getAttributes(): AttributeList
    {
        return $this->attributes;
    }

    public function check(string $type): bool
    {
        return $this->type == $type ? true : false;
    }

    public function __toString(): string
    {
        return "{$this->getType()}";
    }
}