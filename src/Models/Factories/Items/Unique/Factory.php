<?php

namespace Erupt\Models\Factories\Items\Unique;

use Erupt\Models\Factories\BaseFactory;
use Erupt\Interfaces\FactoryModifier;

class Factory extends BaseFactory implements FactoryModifier
{
    protected string $params = "";

    public function __toString(): string
    {
        return 'unique()';
    }
}