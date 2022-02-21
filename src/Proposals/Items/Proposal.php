<?php

namespace Erupt\Proposals\Items;

use Erupt\Proposals\BaseProposal;
use Erupt\Attributes\Containers\AttributeContainer as Container;
use Erupt\Attributes\BaseAttributeContainer;

class Proposal extends BaseProposal
{
    public function makeCorrespondingAttributeContainer(): Container
    {
        return new Container;
    }
}