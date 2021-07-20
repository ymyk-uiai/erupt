<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Interfaces\Resolver;
use Erupt\Models\PropertyValues\Items\RelationshipMethodName\Value as RelationshipMethodName;
use Erupt\Models\PropertyValues\Items\RelationshipName\Value as RelationshipName;
use Erupt\Models\PropertyValues\Items\RelationshipArgs\Value as RelationshipArgs;
use Erupt\Models\PropertyFlags\Items\Flag\Flag as Flag;
use Erupt\Models\ModelFlags\Items\Flag\Flag as ModelFlag;

class MorphOneToManyHas extends BaseProperty
{
    public function complete(): void
    {
        $name = $this->values->get('name');
        $name = preg_replace("/_[a-zA-Z0-9_]+$/", "", $name);
        $capName = ucfirst($name);

        $this->build($this->makeBuilder([
            RelationshipMethodName::class,
            "${name}s",
        ]));
        $this->build($this->makeBuilder([
            RelationshipName::class,
            'morphMany',
        ]));
        $this->build($this->makeBuilder([
            RelationshipArgs::class,
            "${capName}::class, '${name}able'",
        ]));

        $this->getModel()->build2($this->makeBuilder([
            ModelFlag::class,
            "${name}able",
        ]));

        parent::complete();
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        $name = $this->values->get('name');
        $name = preg_replace("/_[a-zA-Z0-9_]+$/", "", $name);
        $capName = ucfirst($name);

        try {
            return match($key) {
                "model" => $this->getCorrespondingModel(),
                "relationshipMethodName" => $this->makeBuilder([
                    RelationshipMethodName::class,
                    "${name}s",
                ]),
                "relationshipName" => $this->makeBuilder([
                    RelationshipName::class,
                    'morphMany',
                ]),
                "relationshipArgs" => $this->makeBuilder([
                    RelationshipArgs::class,
                    "${capName}::class, '${name}able'",
                ]),
                default => parent::getResolver($key, $keys),
            };
        } catch (Exception $e) {
            echo 'Unknown resolve key: ', $e->getMessage(), "\n";
        }
    }

    protected function getCorrespondingModel(): Resolver
    {
        return $this->app->getModel($this->getName());
    }

    protected function getDefaults(): array
    {
        return [
            [
                Flag::class,
                'relationship',
            ],
        ];
    }
}