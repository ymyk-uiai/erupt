<?php

namespace Erupt\Models\Factories;

use Erupt\Foundations\ResolverItem;
use Erupt\Traits\HasParams;
use Erupt\Interfaces\Resolver;

abstract class BaseFactory extends ResolverItem
{
    use HasParams;

    protected function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }

    public function evaluate()
    {
        return $this;
    }
}