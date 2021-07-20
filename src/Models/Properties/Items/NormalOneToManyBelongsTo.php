<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Models\PropertyValues\Items\RelationshipMethodName\Value as RelationshipMethodName;
use Erupt\Models\PropertyValues\Items\RelationshipName\Value as RelationshipName;
use Erupt\Models\PropertyValues\Items\RelationshipArgs\Value as RelationshipArgs;
use Erupt\Interfaces\Resolver;
use Erupt\Models\PropertyFlags\Items\Flag\Flag as Flag;

class NormalOneToManyBelongsTo extends BaseProperty
{
    public function complete(): void
    {
        $name = $this->values->get('name');
        $name = preg_replace("/_[a-zA-Z0-9_]+$/", "", $name);
        $capName = ucfirst($name);

        $this->build($this->makeBuilder([
            RelationshipMethodName::class,
            "${name}",
        ]));
        $this->build($this->makeBuilder([
            RelationshipName::class,
            'belongsTo',
        ]));
        $this->build($this->makeBuilder([
            RelationshipArgs::class,
            "${capName}::class",
        ]));

        if($this->values->getValue('columnType')->getValue() == 'UNSIGNED BIGINT') {
            $this->build($this->makeBuilder([
                Flag::class,
                'hasRelationshipMethod',
            ]));
        }

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
                    "${name}",
                ]),
                "relationshipName" => $this->makeBuilder([
                    RelationshipName::class,
                    'belongsTo',
                ]),
                "relationshipArgs" => $this->makeBuilder([
                    RelationshipArgs::class,
                    "${capName}::class",
                ]),
                default => parent::getResolver($key, $keys),
            };
        } catch (Exception $e) {
            echo 'Unknown resolve key: ', $e->getMessage(), "\n";
        }
    }

    protected function getCorrespondingModel(): Resolver
    {
        $name = rtrim($this->getName(), '_id');

        return $this->app->getModel($name);
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