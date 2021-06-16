<?php

namespace Erupt\Plans\Attributes\Items\Relationship;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Models\Values\Items\Name\Value as NameValue;
use Erupt\Interfaces\SchemaDummyCommand;

class Attribute extends BaseAttribute implements SchemaDummyCommand
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
            ],
            "flags" => [
                'hasRelationshipMethod',
            ],
        ];
    }
}