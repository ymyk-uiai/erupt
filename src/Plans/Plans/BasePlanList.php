<?php

namespace Erupt\Plans\Plans;

use Erupt\Foundations\BaseList;
use Erupt\Plans\Plans\Items\Plan;
use Erupt\Plans\Properties\Lists\PropertyList;
use Erupt\Relationships\Relationships\Lists\RelationshipList;

abstract class BasePlanList extends BaseList
{
    public function __construct(array $modelPlans, RelationshipList $relationships)
    {
        foreach($modelPlans as $type => $data) {
            $this->add(new Plan($type, new PropertyList($type, $data, $relationships)));
        }
    }

    public function add(BasePlan|Self $plan): void
    {
        $this->addItemOrList($plan);
    }

    public function remove(BasePlan|Self $plan): void
    {
        $this->removeItemOrList($plan);
    }
}