<?php

namespace Erupt\Models\Relationships\Items;

use Erupt\Models\Relationships\Bases\BaseRelationship;
use Erupt\Relationships\Members\Member;

class MonoOneToMany extends BaseRelationship
{
    public static function build(Member $member, bool $owner)
    {
        $product = new Self;

        $product->set_name($member->getName());

        $product->set_is_owner($owner);

        return $product;
    }
}