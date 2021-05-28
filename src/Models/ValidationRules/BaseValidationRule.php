<?php

namespace Erupt\Models\ValidationRules;

use Erupt\Foundations\Resolver;
use Erupt\Traits\HasParams;

abstract class BaseValidationRule extends Resolver
{
    use HasParams;

    protected function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }
}