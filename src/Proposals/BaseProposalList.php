<?php

namespace Erupt\Proposals;

use Erupt\Foundation\BaseList;

abstract class BaseProposalList extends BaseList
{
    public function add(BaseProposal|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseProposal|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}