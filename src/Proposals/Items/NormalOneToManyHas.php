<?php

namespace Erupt\Proposals\Items;

use Erupt\Proposals\BaseProposal;
use Erupt\Attributes\Containers\NormalOneToManyHas as Container;
use Erupt\Attributes\BaseAttributeContainer;

class NormalOneToManyHas extends BaseProposal
{
    public function makeCorrespondingAttributeContainer(): Container
    {
        return new Container;
    }
}