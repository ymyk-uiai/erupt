<?php

namespace Erupt\Models\ValidationRules;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToProperty;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Property;
use Erupt\Traits\HasParams;

abstract class BaseValidationRule extends ResolverItemBelongsToProperty
{
    use HasParams;

    public function __construct(Application $app, Model $model, Property $property)
    {
        parent::__construct($app, $model, $property);
    }

    public function build(string|array $args): void
    {
        $this->takeArgs($args);
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }
}