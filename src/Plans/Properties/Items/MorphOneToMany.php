<?php

namespace Erupt\Plans\Properties\Items;

use Erupt\Plans\Properties\BaseProperty;
use Erupt\Plans\Attributes\Containers\MorphOneToMany as CorrespondingContainer;

class MorphOneToMany extends BaseProperty
{
    public function makeContainer(): CorrespondingContainer
    {
        return new CorrespondingContainer;
    }
}