<?php

namespace Erupt\Plans\Constructors\Plans;

use Erupt\Plans\Plans\Plan;
use Erupt\Plans\Lists\Properties\PropertyList;

class PlanConstructor
{
    public static function build($name, $data): Plan
    {
        $plan = new Plan;

        $plan->setName($name);

        $plan->setType($data["type"]);

        $plan->setProperties(PropertyList::build($data["plans"]));

        return $plan;
    }
}