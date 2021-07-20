<?php

namespace Erupt\Plans\Attributes\Items\String;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Models\Factories\Items\Name\Factory as NameFactory;
use Erupt\Models\PropertyValues\Items\ColumnType\Value as ColumnType;
use Erupt\Models\PropertyValues\Items\ValueType\Value as ValueType;
use Erupt\Models\PropertyValues\Items\Name\Value as Name;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name,length?";

    public function getPropertyName(): string
    {
        return $this->args['name'];
    }
    protected string $migrationMethodName = "string";

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
                "VARCHAR",
            ],
            [
                ValueType::class,
                "string",
            ],
            [
                NameFactory::class,
            ],
        ];
    }
}