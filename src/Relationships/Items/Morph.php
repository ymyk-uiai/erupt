<?php

namespace Erupt\Relationships\Items;

use Erupt\Relationships\BaseRelationship;
use Erupt\Primitives\BasePrimitive as Primitive;
use Erupt\Primitives\BasePrimitiveList as PrimitiveList;
use Erupt\Primitives\Lists\PrimitiveList as PlanePrimitiveList;
use Erupt\Plans\BasePlan as Plan;
use Erupt\Proposals\BaseProposal as Proposal;
use Erupt\Proposals\BaseProposalList as ProposalList;

class Morph extends BaseRelationship
{
    protected PrimitiveList $sbs;

    protected Primitive $ob;

    protected function setLhs(string $lhs)
    {
        $models = explode('&', $lhs);

        $this->sbs = new PlanePrimitiveList;

        foreach ($models as $model) {
            $this->sbs->add(PrimitiveList::make($model));
        }
    }

    protected function setRhs(string $rhs)
    {
        $this->ob = PrimitiveList::make($rhs);
    }

    protected function getHasRelationships(Plan $plan): Proposal|ProposalList|bool
    {
        if($this->sbs->includes($plan)) {
            $proposal = $this->getHasProposal($this->ob->getName());
            return $proposal;
        }
        return false;
    }

    protected function getBelongsToRelationships(Plan $plan): Proposal|ProposalList|bool
    {
        if($this->ob->is($plan)) {
            $proposal = $this->getBelongsToProposal($this->sbs->getNames());
            return $proposal;
        }
        return false;
    }
}