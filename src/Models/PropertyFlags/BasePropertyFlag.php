<?php

namespace Erupt\Models\PropertyFlags;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToProperty;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Property;

abstract class BasePropertyFlag extends ResolverItemBelongsToProperty
{
    public function __construct(Application $app, Model $model, Property $property)
    {
        parent::__construct($app, $model, $property);
    }

    public function build(string $key): void
    {
        $this->name = $key;
        $this->bool = true;
    }

    public function check(string $name): bool
    {
        return $this->name == $name && $this->bool;
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