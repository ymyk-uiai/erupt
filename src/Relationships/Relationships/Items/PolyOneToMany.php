<?php

namespace Erupt\Relationships\Relationships\Items;

use Erupt\Application;
use Erupt\Relationships\Relationships\BaseRelationship;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Relationships\Members\Lists\MemberList;
use Erupt\Interfaces\Makers\Items\MigrationMaker;
use Erupt\Models\Relationships\Items\PolyOneToMany as ModelRelationship;

class PolyOneToMany extends BaseRelationship implements MigrationMaker
{
    protected Application $app;

    protected MemberList $sbs;

    protected Member $ob;

    protected int $index;

    public static function build($index, $ls, $r, $app): Self
    {
        $product = new Self;

        $product->app = $app;

        $product->sbs = MemberList::build($ls);

        $product->ob = Member::build($r);

        $product->index = $index;

        return $product;
    }

    public function tryGettingPlan($name)
    {
        if($this->ob->get_name() === $name) {
            return "morphs:${name}able";
        }
    }

    public function getRelationshipPlans(string $modelName):array
    {
        $relationshipPlans = [];

        if($this->sbs->has($modelName)) {
            $relationshipPlans[] = "relationship:{$this->ob->get_name()}";
        }

        if($this->ob->get_name() == $modelName) {
            $relationshipPlans[] = "morphs:${modelName}able";
        }

        return $relationshipPlans;
    }

    public function get_model_relationships($model, $relationships, $app)
    {
        foreach($this->sbs as $sb) {
            if($sb->get_name() == $model->get_name()) {
                $relationships->add(ModelRelationship::build($this->index, $this->ob, true, $app));
            }
        }

        if($this->ob_get_name() == $model->get_name()) {
            foreach($this->sbs as $sb) {
                $relationships->add(ModelRelationship::build($this->index, $sb, false, $app));
            }
        }

        /*
        if($check) {
            $i = $this->ob;
            $relationships->add(ModelRelationship::build($i, true, $app));
        } else if($this->ob->get_name() == $model->get_name()) {
            $is = $this->sbs;
            foreach($is as $i) {
                $relationships->add(ModelRelationship::build($i, false, $app));
            }
        }
        */
    }

    public function ob_get_name(): string
    {
        return $this->ob->get_name();
    }

    public function make_migration_specification()
    {
        return $this->app->get_generators()->make_migration_specifications($this);
    }

    public function get_table_name()
    {
        //  $this->table_name()
        return "poly";
    }

    public function get_command(): string
    {
        return "create_{poly}_table";
    }
}