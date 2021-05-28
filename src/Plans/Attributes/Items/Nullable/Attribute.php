<?php

namespace Erupt\Plans\Attributes\Items\Nullable;

use Erupt\Plans\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "";

    public function evaluate()
    {
        return $this;
    }

    public function getData(): array
    {
        return [
        ];
    }

    public function __toString()
    {
        return "nullable()";
    }
}