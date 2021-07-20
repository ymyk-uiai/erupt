<?php

namespace Erupt\Models\Factories;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToProperty;
use Erupt\Traits\HasParams;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Property;

abstract class BaseFactory extends ResolverItemBelongsToProperty
{
    use HasParams;

    public function __construct(Application $app, Model $model, Property $property)
    {
        parent::__construct($app, $model, $property);
    }

    public function build(string|array $args = ""): void
    {
        $this->takeArgs($args);

        unset($this->params);
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }

    public function evaluate()
    {
        return $this;
    }
}