<?php

namespace Erupt\Relationships\Relationships\Items;

use Erupt\Relationships\Relationships\BaseRelationship;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Plans\Properties\Items\NormalOneToMany as PlanProp;
use Erupt\Plans\Properties\Lists\PropertyList;
use Erupt\Plans\Attributes\Lists\AttributeList;

class NormalOneToMany extends BaseRelationship
{
    protected int $index;

    protected Member $sb;

    protected Member $ob;

    public function __construct(int $index, Member $sb, Member $ob)
    {
        $this->index = $index;

        $this->setSb($sb);

        $this->setOb($ob);
    }

    public function setSb(Member $sb): void
    {
        $this->sb = $sb;
    }

    public function getSb(): Member
    {
        return $this->sb;
    }

    public function setOb(Member $ob): void
    {
        $this->ob = $ob;
    }

    public function getOb(): Member
    {
        return $this->ob;
    }

    public function makeProps(string $type)
    {
        $props = PropertyList::empty();

        if($this->getSb()->check($type)) {
            $key = $this->getOb()->getType();
            $props->add(new PlanProp(new AttributeList("relationship:${key}|has|flag:relationships"), $this));
        }

        if($this->getOb()->check($type)) {
            $key = $this->getSb()->getType();
            $props->add(new PlanProp(new AttributeList("foreignId:${key}_id|belongsTo|relationships"), $this));
        }

        return $props;
    }

    //  makeCorrespondingProp()
}