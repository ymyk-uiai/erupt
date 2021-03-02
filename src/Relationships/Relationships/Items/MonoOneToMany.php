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
            return "foreignId:{$sbName}_id";
        }
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