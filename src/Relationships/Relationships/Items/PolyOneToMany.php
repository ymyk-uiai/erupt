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

    public static function build($ls, $r, $app): Self
    {
        $product = new Self;

        $product->app = $app;

        $product->sbs = MemberList::build($ls);

        $product->ob = Member::build($r);

        return $product;
    }

    public function tryGettingPlan($name)
    {
        if($this->ob->get_name() === $name) {
            return "morphs:${name}able";
        }
    }

    public function get_model_relationships($model, $relationships)
    {
        $check = false;

        foreach($this->sbs as $sb) {
            if($sb->get_name() == $model->get_name()) {
                $check = true;
            }
        }

        if($check) {
            $i = $this->ob;
            $relationships->add(ModelRelationship::build($i, true));
        } else if($this->ob->get_name() == $model->get_name()) {
            $is = $this->sbs;
            foreach($is as $i) {
                $relationships->add(ModelRelationship::build($i, false));
            }
        }
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