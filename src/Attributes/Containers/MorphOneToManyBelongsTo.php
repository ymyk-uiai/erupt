<?php

namespace Erupt\Attributes\Containers;

use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\Items\MorphOneToManyBelongsTo as Property;

class MorphOneToManyBelongsTo extends BaseAttributeContainer
{
    protected function makeCorrespondingProperty(): Property
    {
        return new Property;
    }
}