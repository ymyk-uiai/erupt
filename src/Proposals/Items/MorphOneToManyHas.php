<?php

namespace Erupt\Proposals\Items;

use Erupt\Proposals\BaseProposal;
use Erupt\Attributes\Containers\MorphOneToManyHas as Container;
use Erupt\Attributes\BaseAttributeContainer;

class MorphOneToManyHas extends BaseProposal
{
    public function makeCorrespondingAttributeContainer(): Container
    {
        return new Container;
    }
}