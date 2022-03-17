<?php

namespace Erupt\Attributes\Containers\Morph\OneToMany;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\Morph\OneToMany\Has as Property;

class Has extends BaseAttributeContainer
{
    protected function makeCorrespondingProperty(): Property
    {
        return new Property;
    }
}