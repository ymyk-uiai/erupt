<?php

namespace Erupt\Models\ModelValues;

use Erupt\Foundations\ResolverList;
use Erupt\Traits\BelongsToApp;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Values\BaseValue;
use Exception;

abstract class BaseModelValueList extends ResolverList
{
    use BelongsToApp;
    
    public function __construct()
    {
        //
    }

    public function get(string $key)
    {
        foreach($this as $value) {
            if($value->getKey() == $key) {
                return $value->getValue();
            }
        }

        throw new Exception($key);
    }

    public function getValue(string $key)
    {
        foreach($this as $value) {
            if($value->getKey() == $key) {
                return $value;
            }
        }

        throw new Exception($key);
    }

    public function update(array $values): void
    {
        foreach($values as $value) {
            $this->removeSameType($value);
            $this->add($value);
        }
    }

    protected function removeSameType(BaseValue $remove): void
    {
        foreach($this->list as $value) {
            $class = get_class($remove);
            if($value instanceof $class) {
                $this->remove($value);
            }
        }
    }

    public function add($model): void
    {
        parent::addItemOrList($model);
    }

    public function remove($model): void
    {
        parent::removeItemOrList($model);
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