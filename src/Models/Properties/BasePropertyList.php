<?php

namespace Erupt\Models\Properties;

use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Foundations\ResolverList;
use Erupt\Plans\Properties\Lists\PropertyList;
use Erupt\Plans\Attributes\Containers\AttributeContainer;
use Erupt\Traits\BelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Interfaces\Resolver;
use ReflectionClass;

abstract class BasePropertyList extends ResolverList
{
    use BelongsToApp,
        BelongsToModel;
        
    public static function empty(): Static
    {
        $reflection = new ReflectionClass(Static::class);
        return $reflection->newInstanceWithoutConstructor();
    }

    public function __construct(Application $app, Model $model, PropertyList $planProps)
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
            $this->add($attributeList->makeModelProp($app, $model));
        }
    }

    public function add($prop)
    {
        parent::addItemOrList($prop);
    }

    public function remove($prop)
    {
        parent::removeItemOrList($prop);
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        $props = Static::empty();

        foreach($this->list as $prop) {
            if($prop->getFlag($key)) {
                $props->add($prop);
            }
        }

        return $props;
    }

    public function evaluate()
    {
        return $this;
    }
}