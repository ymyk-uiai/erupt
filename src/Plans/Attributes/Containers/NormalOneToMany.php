<?php

namespace Erupt\Plans\Attributes\Containers;

use Erupt\Plans\Attributes\BaseAttributeContainer;
use Erupt\Plans\Attributes\BaseAttributeList;
use Erupt\Plans\Attributes\Lists\NormalOneToMany as AttributeList;

class NormalOneToMany extends BaseAttributeContainer
{
    protected function makeCorrespondingList(): BaseAttributeList
    {
        return new AttributeList;
    }
}