<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Relationships\Relationships\Bases\BaseRelationship;
use Erupt\Relationships\Members\Member;
use Erupt\Relationships\Lists\Members\MemberList;
use Erupt\Models\Relationships\Items\PolyOneToMany as ModelRelationship;
use Erupt\Interfaces\MigrationMaker;
use Erupt\Application;

class PolyOneToMany extends BaseRelationship implements MigrationMaker
{
    protected Application $app;

    protected MemberList $sbs;

    protected Member $ob;

    public static function build($ls, $r, $app)
    {
        $product = new Self;

        $product->app = $app;

        $product->sbs = MemberList::build($ls);

        $product->ob = Member::build($r);

        return $product;
    }

    public function tryGettingPlan($name)
    {
        if($this->ob->getName() === $name) {
            return "morphs:${name}able";
        }
    }

    public function getModelRelationships($model, $relationships)
    {
        $check = false;

        foreach($this->sbs as $sb) {
            if($sb->getName() == $model->getName()) {
                $check = true;
            }
        }

        if($check) {
            $i = $this->ob;
            $relationships->add(ModelRelationship::build($i, true));
        } else if($this->ob->getName() == $model->getName()) {
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