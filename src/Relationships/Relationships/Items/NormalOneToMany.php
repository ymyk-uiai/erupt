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
            $relationalPlanPropertyString = $this->addDefaultRelationalAttributes("relationship:${key}|has:${key}", $type, $key);
            $props->add(new PlanProp(new AttributeList($relationalPlanPropertyString), "{$this->getOb()}"));
        }

        if($this->getOb()->check($type)) {
            $key = $this->getSb()->getType();
            $relationalPlanPropertyString = $this->addDefaultRelationalAttributes("foreignId:${key}_id|belongsTo:${key}", $type, $key);
            $props->add(new PlanProp(new AttributeList($relationalPlanPropertyString), "{$this->getSb()}"));
        }

        return $props;
    }

    //  makeCorrespondingProp()
}