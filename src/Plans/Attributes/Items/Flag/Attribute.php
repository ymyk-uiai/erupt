<?php

namespace Erupt\Plans\Attributes\Items\Flag;

use Erupt\Plans\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name";

    public function evaluate()
    {
        return $this;
    }

    public function getData(): array
    {
        return [
            "flags" => [
                $this->name,
            ],
        ];
    }
}