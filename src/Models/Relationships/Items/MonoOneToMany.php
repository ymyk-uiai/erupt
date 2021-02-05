<?php

namespace Erupt\Models\Relationships\Items;

use Erupt\Models\Relationships\BaseRelationship;
use Erupt\Relationships\Members\Items\Member;

class MonoOneToMany extends BaseRelationship
{
    public static function build(Member $member, bool $owner): Self
    {
        $product = new Self;

        $product->set_name($member->get_name());

        $product->set_is_owner($owner);

        return $product;
    }
}