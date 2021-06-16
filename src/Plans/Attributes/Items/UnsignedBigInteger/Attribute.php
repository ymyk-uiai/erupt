<?php

namespace Erupt\Plans\Attributes\Items\UnsignedBigInteger;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Models\Values\Items\Name\Value as NameValue;
use Erupt\Models\Values\Items\ColumnType\Value as ColumnTypeValue;
use Erupt\Models\Values\Items\ValueType\Value as ValueTypeValue;
use Erupt\Models\Factories\Items\Zero\Factory as ZeroFactory;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name";

    public function getPropertyName(): string
    {
        return $this->name;
    }

    protected string $migrationMethodName = "unsignedBigInt";
 
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
            "factories" => [
                new ZeroFactory(),
            ],
        ];
    }
}