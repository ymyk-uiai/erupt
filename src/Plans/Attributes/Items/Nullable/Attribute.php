<?php

namespace Erupt\Plans\Attributes\Items\Nullable;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaModifier;

class Attribute extends BaseAttribute implements SchemaModifier
{
    protected string $params = "";

    protected string $migrationMethodName = "nullable";

    public function evaluate()
    {
        return $this;
    }

    public function getBuilders(): array
    {
        return [

        ];
    }
}