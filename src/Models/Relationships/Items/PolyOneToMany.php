<?php

namespace Erupt\Models\Relationships\Items;

use Erupt\Models\Relationships\BaseRelationship;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Interfaces\Makers\Items\MigrationMaker;

class PolyOneToMany extends BaseRelationship implements MigrationMaker
{
    public static function build($index, Member $member, bool $owner, $app): Self
    {
        $product = new Self;

        $product->app = $app;

        $product->index = $index;

        $product->set_name($member->get_name());

        $product->set_is_owner($owner);

        $product->init_flags();

        $product->set_flag("morphHas", $owner ? true : false);
        $product->set_flag("morphBelongs", $owner ? false : true);

        foreach($member->get_updaters() as $updater) {
            $updater->update($product);
        }

        return $product;
    }

    public function get_r_method(): string
    {
        return match($this->is_owner) {
            true => "morphMany",
            false => "morphs",
        };
    }

    public function get_r_method_args(): string
    {
        return match($this->is_owner) {
            true => "'".$this->app->get_model($this->name)->resolve("files.model.class_name")."', '".$this->name."able'",
            false => "",
        };
    }

    public function get_impl_method_name(): string
    {
        return match($this->is_owner) {
            true => $this->app->get_model($this->name)->get_name()."s",
            false => $this->app->get_model($this->name)->get_name()."able",
        };
    }

    public function make_migration_specification()
    {
        return $this->app->get_generators()->make_migration_specifications($this);
    }

    public function get_table_name()
    {
        //  $this->table_name()
        return $this->name;
    }

    public function get_command(): string
    {
        return "create_{$this->name}_table_poly";
    }
}