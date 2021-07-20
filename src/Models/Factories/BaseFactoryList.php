<?php

namespace Erupt\Models\Factories;

use Erupt\Application;
use Erupt\Foundations\ResolverListBelongsToProperty;
use Erupt\Interfaces\FactoryCommand;
use Erupt\Interfaces\FactoryMain;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Property;
use Erupt\Models\Values\Items\Value\Value;

abstract class BaseFactoryList extends ResolverListBelongsToProperty
{
    public function __construct(Application $app, Model $model, Property $property)
    {
        parent::__construct($app, $model, $property);
    }

    public function getResult(): Value
    {
        $result = [];

        $command = $this->getCommand();
        $modifiers = $this->getModifiers();

        $methods = array_merge($modifiers, [$command]);

        foreach($methods as $method) {
            $result[] = strval($method);
        }

        if($command instanceof FactoryCommand) {
            array_unshift($result, '$this', 'faker');
        }

        /*  getResult() -> __toString()
        return match($this->isCommand()) {
            true => '$this->faker'.implode('->', $methods),
            false => implode('->', $methods),
        };
        */

        return new Value(implode('->', $result));
    }

    public function getCommand(): FactoryMain
    {
        foreach($this as $factory) {
            if($factory instanceof FactoryMain) {
                return $factory;
            }
        }

        throw new Exception("no command");
    }

    protected function getModifiers(): array
    {
        $result = [];

        foreach($this as $factory) {
            if($factory instanceof FactoryModifier) {
                $result[] = $factory->getModifier();
            }
        }

        return $result;
    }

    public function update(array $values): void
    {
        foreach($values as $value) {
            if($value instanceof FactoryMain) {
                $this->removeMainFactory();
            }
            $this->add($value);
        }
    }

    protected function removeMainFactory(): void
    {
        foreach($this as $factory) {
            if($factory instanceof FactoryMain) {
                $this->remove($factory);
            }
        }
    }

    public function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }

    public function evaluate()
    {
        return $this;
    }

    public function add($itemOrList)
    {
        parent::addItemOrList($itemOrList);
    }

    public function remove($itemOrList)
    {
        parent::removeItemOrList($itemOrList);
    }
}