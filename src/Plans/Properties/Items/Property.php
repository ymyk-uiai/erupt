<?php

namespace Erupt\Plans\Properties\Items;

use Erupt\Plans\Properties\BaseProperty;
use Erupt\Plans\Attributes\Containers\OrdinaryProperty as CorrespondingContainer;

class Property extends BaseProperty
{
    public function makeContainer(): CorrespondingContainer
    {
        return new CorrespondingContainer;
    }
}