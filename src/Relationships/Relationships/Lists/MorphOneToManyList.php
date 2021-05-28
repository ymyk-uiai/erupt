<?php

namespace Erupt\Relationships\Relationships\Lists;

use Erupt\Relationships\Relationships\BaseRelationshipList;
use Erupt\Relationships\Members\Lists\MemberList;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Relationships\Attributes\Lists\AttributeList;
use Erupt\Relationships\Relationships\Items\MorphOneToMany;

class MorphOneToManyList extends BaseRelationshipList
{
    public function __construct(int $index, array $relationship)
    {
        foreach($relationship["rhs"]["models"] as $rhs) {
            $members = new MemberList($relationship["lhs"]["models"]);
            $member = new Member($rhs["type"], new AttributeList($rhs["attrs"]));
            $this->add(new MorphOneToMany($index, $members, $member));
        }
    }
}