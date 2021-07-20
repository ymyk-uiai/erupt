<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Models\PropertyFlags\Items\Flag\Flag as Flag;

class OrdinaryProperty extends BaseProperty
{
    protected function getDefaults(): array
    {
        return [
            [
                Flag::class,
                'ordinary',
            ],
        ];
    }
}