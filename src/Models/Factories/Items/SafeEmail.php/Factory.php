<?php

namespace Erupt\Models\Factories\Items\SafeEmail;

use Erupt\Models\Factories\BaseFactory;
use Erupt\Interfaces\FactoryCommand;

class Factory extends BaseFactory implements FactoryCommand
{
    public function __toString(): string
    {
        return 'safeEmail';
    }
}