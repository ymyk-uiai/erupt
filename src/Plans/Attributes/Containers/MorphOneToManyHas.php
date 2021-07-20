<?php

namespace Erupt\Plans\Attributes\Containers;

use Erupt\Plans\Attributes\BaseAttributeContainer;
use Erupt\Plans\Attributes\BaseAttributeList;
use Erupt\Plans\Attributes\Lists\MorphOneToManyHas as AttributeList;

class MorphOneToManyHas extends BaseAttributeContainer
{
    protected function makeCorrespondingList(): BaseAttributeList
    {
        return new AttributeList;
    }
}