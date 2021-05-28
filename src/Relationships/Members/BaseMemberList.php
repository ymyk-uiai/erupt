<?php

namespace Erupt\Relationships\Members;

use Erupt\Traits\HasList;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Relationships\Attributes\Lists\AttributeList;
use IteratorAggregate;
use Erupt\Foundations\BaseIterator;

abstract class BaseMemberList implements IteratorAggregate
{
    use HasList;

    public function getIterator()
    {
        return new BaseIterator($this->list);
    }

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