<?php

namespace Erupt\Models\PropertyValues;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToProperty;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Property;

abstract class BasePropertyValue extends ResolverItemBelongsToProperty
{
    protected int|string|bool $value;

    public function __construct(Application $app, Model $model, Property $property)
    {
        parent::__construct($app, $model, $property);
    }

    public function build($value): void
    {
        $this->value = $value;
    }

    abstract public function getKey(): string;

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