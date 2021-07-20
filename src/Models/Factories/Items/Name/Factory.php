<?php

namespace Erupt\Models\Factories\Items\Name;

use Erupt\Models\Factories\BaseFactory;
use Erupt\Interfaces\FactoryCommand;

class Factory extends BaseFactory implements FactoryCommand
{
    protected string $params = "";

    public function __toString(): string
    {
        return 'name';
    }
}