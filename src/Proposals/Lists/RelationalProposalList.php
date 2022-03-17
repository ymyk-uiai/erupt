<?php

namespace Erupt\Proposals\Lists;

use Erupt\Proposals\BaseProposalList;
use Erupt\Plans\BasePlan;

class RelationalProposalList extends BaseProposalList
{
    public function filter(BasePlan $plan): self
    {
        $list = new self;
        foreach($this as $proposal) {
            if($proposal->match($plan)) {
                $list->add($proposal);
            }
        }
        return $list;
    }
}