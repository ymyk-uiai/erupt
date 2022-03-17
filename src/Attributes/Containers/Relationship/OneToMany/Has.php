<?php

namespace Erupt\Attributes\Containers\Relationship\OneToMany;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\Relationship\OneToMany\Has as Property;

class Has extends BaseAttributeContainer
{
    protected function makeCorrespondingProperty(): Property
    {
        return new Property;
    }
}