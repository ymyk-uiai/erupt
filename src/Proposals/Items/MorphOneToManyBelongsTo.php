<?php

namespace Erupt\Proposals\Items;

use Erupt\Proposals\BaseProposal;
use Erupt\Attributes\Containers\MorphOneToManyBelongsTo as Container;
use Erupt\Attributes\BaseAttributeContainer;

class MorphOneToManyBelongsTo extends BaseProposal
{
    public function makeCorrespondingAttributeContainer(): Container
    {
        return new Container;
    }
}