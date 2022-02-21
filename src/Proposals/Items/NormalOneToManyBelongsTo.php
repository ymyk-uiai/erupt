<?php

namespace Erupt\Proposals\Items;

use Erupt\Proposals\BaseProposal;
use Erupt\Attributes\Containers\NormalOneToManyBelongsTo as Container;
use Erupt\Attributes\BaseAttributeContainer;

class NormalOneToManyBelongsTo extends BaseProposal
{
    public function makeCorrespondingAttributeContainer(): Container
    {
        return new Container;
    }
}