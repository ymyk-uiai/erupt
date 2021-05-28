<?php

namespace Erupt\Relationships\Relationships\Lists;

use Erupt\Relationships\Relationships\BaseRelationshipList;
use Erupt\Relationships\Relationships\Items\NormalOneToMany;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Relationships\Attributes\Lists\AttributeList;

class NormalOneToManyList extends BaseRelationshipList
{
    public function __construct(int $index, array $relationship)
    {
        foreach($relationship["rhs"]["models"] as $rhsModel) {
            $lhsModel = $relationship["lhs"]["models"][0];

            $member1 = new Member($lhsModel["type"], new AttributeList($lhsModel["attrs"]));
            $member2 = new Member($rhsModel["type"], new AttributeList($rhsModel["attrs"]));

            $this->add(new NormalOneToMany($index, $member1, $member2));
        }
    }
}