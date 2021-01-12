<?php

namespace Erupt\Relationships\Lists\Members;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Relationships\Members\Member;

class MemberList extends BaseList
{
    public static function build($strs)
    {
        $list = new Self;

        foreach($strs as $str) {
            $list->add(Member::build($str));
        }

        return $list;
    }

    public function add($member)
    {
        parent::add($member);
    }

    public function remove($member_s)
    {
        parent::remove($member_s);
    }
}