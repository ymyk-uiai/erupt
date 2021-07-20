<?php

namespace Erupt\Plans\Attributes\Items\Flag;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Models\PropertyFlags\Items\Flag\Flag;

class Attribute extends BaseAttribute
{
    protected string $params = "name";

    public function evaluate()
    {
        return $this;
    }

    public function getBuilders(): array
    {
        return [
            [
                Flag::class,
                $this->args['name'],
            ]
        ];
    }
}