<?php

namespace Erupt\Relationships;

use Erupt\Foundation\BaseListItem;
use Erupt\Plans\BasePlan as Plan;
use Erupt\Proposals\BaseProposal as Proposal;
use Erupt\Proposals\BaseProposalList as ProposalList;
use Erupt\Proposals\Lists\ProposalList as PlaneProposalList;

abstract class BaseRelationship extends BaseListItem
{
    public static function build(array|string $lhs, string $rhs): static
    {
        $product = new static;
        $product->setRhs($rhs);
        $product->setLhs($lhs);
        return $product;
    }

    protected function setLeftModel(string $model)
    {
        //
    }

    protected function setRightModel(string $model)
    {
        //
    }

    public function makeProposals(Plan $plan): Proposal|ProposalList
    {
        $proposals = new PlaneProposalList;

        $p = $this->getHasRelationships($plan);
        if(!!$p) {
            $proposals->add($p);
        }

        $p = $this->getBelongsToRelationships($plan);
        if(!!$p) {
            $proposals->add($p);
        }

        return $proposals;
    }
}