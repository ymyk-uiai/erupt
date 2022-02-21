<?php

namespace Erupt\Attributes\Containers;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\MorphOneToManyHas as Property;

class MorphOneToManyHas extends BaseAttributeContainer
{
    protected function makeCorrespondingProperty(): Property
    {
        return new Property;
    }
}