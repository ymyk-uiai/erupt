<?php

namespace Erupt\Plans\Attributes\Containers;

use Erupt\Plans\Attributes\BaseAttributeContainer;
use Erupt\Plans\Attributes\BaseAttributeList;
use Erupt\Plans\Attributes\Lists\NormalOneToManyBelongsTo as AttributeList;

class NormalOneToManyBelongsTo extends BaseAttributeContainer
{
    protected function makeCorrespondingList(): BaseAttributeList
    {
        return new AttributeList;
    }
}