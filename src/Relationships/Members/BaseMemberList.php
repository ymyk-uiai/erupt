<?php

namespace Erupt\Relationships\Members;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Relationships\Members\BaseMember;
use Erupt\Relationships\Members\Items\Member;

abstract class BaseMemberList extends BaseList
{
    public static function build(array $strs): Self
    {
        $list = new Static;

        foreach($strs as $str) {
            $list->add(Member::build($str));
        }

        return $list;
    }

    //  Unit Type BaseMember|BaseMemberList
    public function add($member)
    {
        parent::add($member);
    }

    public function remove($member_s)
    {
        parent::remove($member_s);
    }
}