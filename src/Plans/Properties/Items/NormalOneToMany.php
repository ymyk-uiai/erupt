<?php

namespace Erupt\Plans\Properties\Items;

use Erupt\Plans\Properties\BaseProperty;
use Erupt\Plans\Attributes\Containers\NormalOneToMany as CorrespondingContainer;

class NormalOneToMany extends BaseProperty
{
    public function makeContainer(): CorrespondingContainer
    {
        return new CorrespondingContainer;
    }
}