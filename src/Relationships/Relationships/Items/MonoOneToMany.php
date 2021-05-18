<?php

namespace Erupt\Relationships\Relationships\Items;

use Erupt\Relationships\Relationships\BaseRelationship;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Models\Relationships\Items\MonoOneToMany as ModelRelationship;

class MonoOneToMany extends BaseRelationship
{
    protected Member $sb;

    protected Member $ob;

    protected int $index;

    public static function build($index, $lhs, $rhs): Self
    {
        $product = new Self;

        $product->index = $index;

        $product->sb = Member::build($lhs);

        $product->ob = Member::build($rhs);

        return $product;
    }

    public function tryGettingPlan($name)
    {
        $sbName = $this->sb->get_name();

        if($this->ob->get_name() === $name) {
            if($this->sb->get_name() === "user") {
                return "foreignId:{$sbName}_id&display&relationship";
            } else if($this->ob->get_name() === "comment") {
                return "foreignId:{$sbName}_id";
            }
        }

    }

    public function getRelationshipPlans(string $modelName): array
    {
        $relationshipPlans = [];

        if($this->sb->get_name() == $modelName) {
            $relationshipPlans[] = "relationship:{$this->ob->get_name()}";
        }

        if($this->ob->get_name() == $modelName) {
            $relationshipPlans[] = "foreignId:{$this->sb->get_name()}_id";
        }

        return $relationshipPlans;
    }

    public function get_model_relationships($model, $relationships, $app)
    {
        if($this->sb->get_name() == $model->get_name()) {
            $i = $this->ob;
            $relationships->add(ModelRelationship::build($this->index, $i, true, $app));
        } else if($this->ob->get_name() == $model->get_name()) {
            $i = $this->sb;
            $relationships->add(ModelRelationship::build($this->index, $i, false, $app));
        } else {
            return false;
        }
    }
}