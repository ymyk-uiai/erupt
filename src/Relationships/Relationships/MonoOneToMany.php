<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Relationships\Relationships\Bases\BaseRelationship;
use Erupt\Relationships\Members\Member;
use Erupt\Models\Relationships\Items\MonoOneToMany as ModelRelationship;

class MonoOneToMany extends BaseRelationship
{
    protected Member $sb;

    protected Member $ob;

    public static function build($lhs, $rhs): Self
    {
        $product = new Self;

        $product->sb = Member::build($lhs);

        $product->ob = Member::build($rhs);

        return $product;
    }

    public function tryGettingPlan($name)
    {
        $sbName = $this->sb->getName();

        if($this->ob->getName() === $name) {
            return "foreignId:${sbName}_id";
        }
    }

    public function getModelRelationships($model, $relationships)
    {
        if($this->sb->getName() == $model->getName()) {
            $i = $this->ob;
            $relationships->add(ModelRelationship::build($i, true));
        } else if($this->ob->getName() == $model->getName()) {
            $i = $this->sb;
            $relationships->add(ModelRelationship::build($i, false));
        } else {
            return false;
        }
    }
}