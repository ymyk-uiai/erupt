<?php

namespace Erupt\Models\Factories\Items\Name;

use Erupt\Models\Factories\BaseFactory;
use Erupt\Interfaces\FactoryCommand;

class Factory extends BaseFactory implements FactoryCommand
{
    public function __toString(): string
    {
        return 'name';
    }
}