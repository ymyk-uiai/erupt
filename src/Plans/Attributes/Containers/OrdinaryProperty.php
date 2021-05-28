<?php

namespace Erupt\Plans\Attributes\Containers;

use Erupt\Plans\Attributes\BaseAttributeContainer;
use Erupt\Plans\Attributes\BaseAttributeList;
use Erupt\Plans\Attributes\Lists\OrdinaryProperty as AttributeList;

class OrdinaryProperty extends BaseAttributeContainer
{
    protected function makeCorrespondingList(): BaseAttributeList
    {
        return new AttributeList;
    }
}