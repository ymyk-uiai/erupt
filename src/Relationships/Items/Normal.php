<?php

namespace Erupt\Relationships\Items;

use Erupt\Relationships\BaseRelationship;
use Erupt\Primitives\BasePrimitive as Primitive;
use Erupt\Primitives\BasePrimitiveList as PrimitiveList;
use Erupt\Plans\BasePlan as Plan;
use Erupt\Proposals\BaseProposal as Proposal;
use Erupt\Proposals\BaseProposalList as ProposalList;

class Normal extends BaseRelationship
{
    protected Primitive $sb;

    protected Primitive $ob;

    protected function setLhs(string $lhs)
    {
        $this->sb = PrimitiveList::make($lhs);
    }

    protected function setRhs(string $rhs)
    {
        $this->ob = PrimitiveList::make($rhs);
    }

    protected function getHasRelationships(Plan $plan): Proposal|ProposalList|bool
    {
        if($this->sb->is($plan)) {
            $proposal = $this->getHasProposal($this->ob->getName());
            return $proposal;
        }
        return false;
    }

    protected function getBelongsToRelationships(Plan $plan): Proposal|ProposalList|bool
    {
        if($this->ob->is($plan)) {
            $proposal = $this->getBelongsToProposal($this->sb->getName());
            return $proposal;
        }
        return false;
    }
}