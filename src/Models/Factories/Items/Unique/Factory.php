<?php

namespace Erupt\Models\Factories\Items\Unique;

use Erupt\Models\Factories\BaseFactory;
use Erupt\Interfaces\FactoryModifier;

class Factory extends BaseFactory implements FactoryModifier
{
    public function __toString(): string
    {
        return 'unique()';
    }
}