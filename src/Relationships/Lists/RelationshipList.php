<?php

namespace Erupt\Relationships\Lists;

use Erupt\Relationships\BaseRelationshipList;
use Erupt\Proposals\Lists\RelationalProposalList;

class RelationshipList extends BaseRelationshipList
{
    public function makeProposals(): RelationalProposalList
    {
        $proposalList = new RelationalProposalList;
        foreach($this as $relationship) {
            $proposalList->add($relationship->makeProposals());
        }
        return $proposalList;
    }
}