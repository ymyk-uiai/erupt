<?php

namespace Erupt\Models\Properties;

use Erupt\Application;
use Erupt\Foundations\ResolverListBelongsToModel;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Plans\Attributes\Containers\AttributeContainer;
use Erupt\Plans\Properties\Lists\PropertyList as PlanPropertyList;

abstract class BasePropertyList extends ResolverListBelongsToModel
{
    public function __construct(Application $app, Model $model)
    {
        parent::__construct($app, $model);
    }

    public function build(PlanPropertyList $planProps): void
    {
        $rootContainer = new AttributeContainer;

        foreach($planProps as $planProp) {
            $container = $planProp->makeContainer();
            foreach($planProp->getAttributes() as $attribute) {
                $container->pack($attribute->build());
            }
            $rootContainer->add($container);
        }

        foreach($rootContainer as $attributeList) {
            $this->add($attributeList->makeModelProp($this->app, $this->model));
        }
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        $props = Static::makeEmpty();

        foreach($this->list as $prop) {
            if($prop->checkFlag($key)) {
                $props->add($prop);
            }
        }

        return $props;
    }

    public function evaluate()
    {
        return $this;
    }

    public function add($prop)
    {
        parent::addItemOrList($prop);
    }

    public function remove($prop)
    {
        parent::removeItemOrList($prop);
    }
}