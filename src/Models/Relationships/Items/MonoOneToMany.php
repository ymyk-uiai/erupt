<?php

namespace Erupt\Models\Relationships\Items;

use Erupt\Models\Relationships\BaseRelationship;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Application;

class MonoOneToMany extends BaseRelationship
{
    protected Application $app;

    public static function build($index,Member $member, bool $owner, $app): Self
    {
        $product = new Self;

        $product->app = $app;

        $product->index = $index;

        $product->set_name($member->get_name());

        $product->set_is_owner($owner);

        $product->init_flags();

        $product->set_flag("has", $owner ? true : false);
        $product->set_flag("belongs", $owner ? false : true);

        foreach($member->get_updaters() as $updater) {
            $updater->update($product);
        }

        return $product;
    }

    public function get_r_method(): string
    {
        return match($this->is_owner) {
            true => "hasMany",
            false => "belongsTo",
        };
    }

    public function get_r_method_args(): string
    {
        return match($this->is_owner) {
            true => "'".$this->app->get_model($this->name)->resolve("files.model.class_name")."'",
            false => "'".$this->app->get_model($this->name)->resolve("files.model.class_name")."'",
        };
    }
}