<?php

namespace Erupt\Plans\Attributes\Items\Relationship;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaDummyCommand;
use Erupt\Models\PropertyValues\Items\Name\Value as Name;
use Erupt\Models\PropertyFlags\Items\Flag\Flag;

class Attribute extends BaseAttribute implements SchemaDummyCommand
{
    protected string $params = "name";

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
                Flag::class,
                'hasRelationshipMethod',
            ],
        ];
    }
}