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

    public function has(string $name): bool
    {
        foreach($this->list as $member) {
            if($member->get_name() == $name) {
                return true;
            }
        }

        return false;
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