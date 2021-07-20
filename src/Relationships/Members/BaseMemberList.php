<?php

namespace Erupt\Relationships\Members;

use Erupt\Relationships\Members\Items\Member;
use Erupt\Relationships\Attributes\Lists\AttributeList;
use Erupt\Foundations\BaseList;

abstract class BaseMemberList extends BaseList
{
    public function __construct(array $models)
    {
        foreach($models as $model) {
            $this->add(new Member($model['type'], new AttributeList($model['attrs'])));
        }
    }

    public function has(string $type): bool
    {
        foreach($this->list as $member) {
            if($member->getType() == $type) {
                return true;
            }
        }

        return false;
    }

    public function __toString(): string
    {
        return implode(', ', array_reduce($this->list, function ($carry, $item) {
            array_push($carry, $item->getType());

            return $carry;
        }, []));
    }

    public function add(BaseMember|BaseMemberList $item): void
    {
        if($item instanceof BaseMemberList) {
            foreach($item as $i) {
                $this->addItem($i);
            }
        } else {
            $this->addItem($item);
        }
    }
}