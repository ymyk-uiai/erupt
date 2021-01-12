<?php

namespace Erupt\Models\Relationships\Items;

use Erupt\Models\Relationships\Bases\BaseRelationship;
use Erupt\Relationships\Members\Member;
use Erupt\Interfaces\MigrationMaker;

class PolyOneToMany extends BaseRelationship implements MigrationMaker
{
    public static function build(Member $member, bool $owner)
    {
        $product = new Self;

        $product->set_name($member->getName());

        $product->set_is_owner($owner);

        return $product;
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