<?php

namespace Erupt\Plans\Attributes\Items\AutoIncrements;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaModifier;

class Attribute extends BaseAttribute implements SchemaModifier
{
    protected string $params = "name";
 
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
        return "autoIncrements()";
    }
}