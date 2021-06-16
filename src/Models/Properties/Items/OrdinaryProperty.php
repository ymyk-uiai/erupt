<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;

class OrdinaryProperty extends BaseProperty
{
    protected function getDefaultFlags(): array
    {
        return [
            'ordinary' => true,
        ];
    }
}