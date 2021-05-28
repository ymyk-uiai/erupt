<?php

namespace Erupt\Relationships\Relationships\Items;

use Erupt\Relationships\Relationships\BaseRelationship;
use Erupt\Relationships\Members\Items\Member;
use Erupt\Relationships\Members\Lists\MemberList;
use Erupt\Plans\Properties\Items\MorphOneToMany as PlanProp;
use Erupt\Plans\Properties\Lists\PropertyList;
use Erupt\Plans\Attributes\Lists\AttributeList;

class MorphOneToMany extends BaseRelationship
{
    protected int $index;

    protected MemberList $sbs;

    protected Member $ob;

    public function __construct(int $index, MemberList $sbs, Member $ob)
    {
        $this->index = $index;

        $this->setSbs($sbs);

        $this->setOb($ob);
    }

    public function setSbs(MemberList $sbs): void
    {
        $this->sbs = $sbs;
    }

    public function getSbs(): MemberList
    {
        return $this->sbs;
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

        if($this->getSbs()->has($type)) {
            $key = $this->getOb()->getType();
            $props->add(new PlanProp(new AttributeList("relationship:${key}|has|relationships"), $this));
        }

        if($this->getOb()->check($type)) {
            $key = $this->getOb()->getType();
            $props->add(new PlanProp(new AttributeList("morphs:${key}able|belongsTo|flag:relationships"), $this));
        }

        return $props;
    }

    //  makeCorrespondingPlanProps
    //  makeCorrespondingPlanProp
}