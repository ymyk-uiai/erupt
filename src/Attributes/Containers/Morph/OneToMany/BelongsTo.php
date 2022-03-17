<?php

namespace Erupt\Attributes\Containers\Morph\OneToMany;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\Morph\OneToMany\BelongsTo as Property;

class BelongsTo extends BaseAttributeContainer
{
    protected function makeCorrespondingProperty(): Property
    {
        return new Property;
    }
}