<?php

namespace Erupt\Models\ValidationRules;

use Erupt\Application;
use Erupt\Foundations\ResolverListBelongsToProperty;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Property;

abstract class BaseValidationRuleList extends ResolverListBelongsToProperty
{
    public function __construct(Application $app, Model $model, Property $property)
    {
        parent::__construct($app, $model, $property);
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        $props = Static::empty();

        foreach($this->list as $prop) {
            if($prop->get_flag($key)) {
                $props->add($prop);
            }
        }

        return $props;
    }

    public function evaluate()
    {
        return $this;
    }

    public function add($model): void
    {
        parent::addItemOrList($model);
    }

    public function remove($model): void
    {
        parent::removeItemOrList($model);
    }
}