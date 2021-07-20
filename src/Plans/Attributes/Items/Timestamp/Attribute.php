<?php

namespace Erupt\Plans\Attributes\Items\Timestamp;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Models\PropertyValues\Items\ColumnType\Value as ColumnType;
use Erupt\Models\PropertyValues\Items\ValueType\Value as ValueType;
use Erupt\Models\PropertyValues\Items\Name\Value as Name;
use Erupt\Models\Factories\Items\Now\Factory as Now;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name,precision?";

    public function getPropertyName(): string
    {
        return $this->args['name'];
    }
    protected string $migrationMethodName = "timestamp";

    public function evaluate()
    {
        return $this;
    }

    public function getBuilders(): array
    {
        return [
            [
                ColumnType::class,
                "TIMESTAMP",
            ],
            [
                ValueType::class,
                "string",
            ],
            [
                Name::class,
                $this->args['name'],
            ],
            [
                Now::class,
            ],
        ];
    }
}