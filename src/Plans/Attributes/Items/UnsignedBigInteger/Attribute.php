<?php

namespace Erupt\Plans\Attributes\Items\UnsignedBigInteger;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Models\Factories\Items\Zero\Factory as Zero;
use Erupt\Models\PropertyValues\Items\ColumnType\Value as ColumnType;
use Erupt\Models\PropertyValues\Items\ValueType\Value as ValueType;
use Erupt\Models\PropertyValues\Items\Name\Value as Name;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name";

    public function getPropertyName(): string
    {
        return $this->args['name'];
    }

    protected string $migrationMethodName = "unsignedBigInt";
 
    public function evaluate()
    {
        return $this;
    }

    public function getBuilders(): array
    {
        return [
            [
                Name::class,
                $this->args['name'],
            ],
            [
                ColumnType::class,
                "UNSIGNED BIGINT",
            ],
            [
                ValueType::class,
                "integer",
            ],
            [
                Zero::class,
            ],
        ];
    }
}