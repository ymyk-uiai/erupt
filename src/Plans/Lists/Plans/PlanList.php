<?php

namespace Erupt\Plans\Lists\Plans;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Plans\Plans\Plan;

class PlanList extends BaseList
{
    public static function build($config, $relationships): PlanList
    {
        $merged = Self::mergeRelationships($config, $relationships);

        $planList = new PlanList;

        foreach($merged as $name => $data) {
            $plan = Plan::build($name, $data);

            $planList->add($plan);
        }

        return $planList;
    }
    
    protected static function mergeRelationships($config, $relationships)
    {
        $configModels = $config["models"];

        foreach($config["models"] as $name => $data) {
            $origPlans = $data["plans"];
            $relationshipPlans = Self::getPlans($relationships, $name);
            $configModels[$name]["plans"] = array_merge($origPlans, $relationshipPlans);
        }

        return $configModels;
    }

    protected static function getPlans($relationships, $name)
    {
        $result = [];

        foreach($relationships as $relationship) {
            if($plan = $relationship->tryGettingPlan($name)) {
                $result[] = $plan;
            }
        }

        return $result;
    }

    public function add($plan)
    {
        parent::add($plan);
    }
}