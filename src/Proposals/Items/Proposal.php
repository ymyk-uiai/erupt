<?php

namespace Erupt\Proposals\Items;

use Erupt\Proposals\BaseProposal;
use Erupt\Attributes\Containers\AttributeContainer as Container;

class Proposal extends BaseProposal
{
    protected static function getCorrespondingContainerName(): string
    {
        return "AttributeContainer";
    }
}