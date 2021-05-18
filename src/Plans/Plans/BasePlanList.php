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

        foreach($merged as $modelName => $data) {
            $plan = Plan::build($modelName, $data);

            $planList->add($plan);
        }

        return $planList;
    }

    protected static function merge_relationships($config, $relationships)
    {
        $configModels = $config["models"];

        foreach($config["models"] as $name => $data) {
            $configModels[$name]["relationshipPlans"] = Self::getRelationshipPlans($name, $relationships);
        }

        return $configModels;
    }

    protected static function getRelationshipPlans(string $modelName, $relationships): array
    {
        $relationshipPlans = [];

        foreach($relationships as $relationship) {
            $relationshipPlans = array_merge($relationshipPlans, $relationship->getRelationshipPlans($modelName));
        }

        return $relationshipPlans;
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