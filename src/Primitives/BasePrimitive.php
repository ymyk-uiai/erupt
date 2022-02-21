<?php

namespace Erupt\Primitives;

use Erupt\Foundation\BaseListItem;
use Erupt\Plans\BasePlan as Plan;

abstract class BasePrimitive extends BaseListItem
{
    public function is(Plan $plan): bool
    {
        return $plan->getName() == $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}