<?php

namespace Erupt\Attributes\Containers\Relationship\OneToMany;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\Relationship\OneToMany\BelongsTo as Property;

class BelongsTo extends BaseAttributeContainer
{
    protected function makeCorrespondingProperty(): Property
    {
        return new Property;
    }
}