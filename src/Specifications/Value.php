<?php

namespace Erupt\Specifications;

use Erupt\Foundations\ResolverItem;
use Erupt\Interfaces\Resolver;

class Value extends ResolverItem
{
    protected int|string|bool $value;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    public function setValue(int|string|bool $value)
    {
        $this->value = $value;
    }

    public function getValue(): int|string|bool
    {
        return $this->value;
    }

    public function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }

    public function evaluate()
    {
        return $this->value;
    }
}