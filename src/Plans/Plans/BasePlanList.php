<?php

namespace Erupt\Plans\Plans;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Plans\Plans\Items\Plan;

abstract class BasePlanList extends BaseList
{
    public static function build($config, $relationships): Self
    {
        $merged = Self::merge_relationships($config, $relationships);

        $planList = new Static;

        foreach($merged as $name => $data) {
            $plan = Plan::build($name, $data);

            $planList->add($plan);
        }

        return $planList;
    }
    
    protected static function merge_relationships($config, $relationships)
    {
        $configModels = $config["models"];

        foreach($config["models"] as $name => $data) {
            $origPlans = $data["plans"];
            $relationshipPlans = Self::get_plans($relationships, $name);
            $configModels[$name]["plans"] = array_merge($origPlans, $relationshipPlans);
        }

        return $configModels;
    }

    protected static function get_plans($relationships, $name)
    {
        $result = [];

        foreach($relationships as $relationship) {
            if($plan = $relationship->tryGettingPlan($name)) {
                $result[] = $plan;
            }
        }

        return $result;
    }

    //  Unit Type BasePlan|BasePlanList
    public function add($plan)
    {
        parent::add($plan);
    }
}