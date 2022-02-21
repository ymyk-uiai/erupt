<?php

namespace Erupt\Attributes\Containers;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\NormalOneToManyHas as Property;

class NormalOneToManyHas extends BaseAttributeContainer
{
    protected function makeCorrespondingProperty(): Property
    {
        return new Property;
    }
}