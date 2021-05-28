<?php

namespace Erupt\Plans\Attributes\Items\UnsignedBigInteger;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Models\Values\Items\Name\Value as NameValue;
use Erupt\Models\Values\Items\ColumnType\Value as ColumnTypeValue;
use Erupt\Models\Values\Items\ValueType\Value as ValueTypeValue;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name";
 
    public function evaluate()
    {
        return $this;
    }

    public function getData(): array
    {
        return [
            "values" => [
                new NameValue($this->name),
                new ColumnTypeValue("UNSIGNED BIGINT"),
                new ValueTypeValue("integer"),
            ],
        ];
    }

    public function __toString()
    {
        return "unsignedBigInt('{$this->name}')";
    }
}