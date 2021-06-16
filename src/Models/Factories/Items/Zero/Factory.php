<?php

namespace Erupt\Models\Factories\Items\Zero;

use Erupt\Models\Factories\BaseFactory;
use Erupt\Interfaces\FactoryMain;

class Factory extends BaseFactory implements FactoryMain
{
    public function __toString(): string
    {
        return '0';
    }
}