<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Interfaces\Resolver;
use Erupt\Models\PropertyValues\Items\RelationshipMethodName\Value as RelationshipMethodName;
use Erupt\Models\PropertyValues\Items\RelationshipName\Value as RelationshipName;
use Erupt\Models\PropertyValues\Items\RelationshipArgs\Value as RelationshipArgs;
use Erupt\Models\PropertyFlags\Items\Flag\Flag as Flag;

class MorphOneToManyBelongsTo extends BaseProperty
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
            'morphTo',
        ]));
        $this->build($this->makeBuilder([
            RelationshipArgs::class,
            "",
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
                "models" => $this->getCorrespondingModels(),
                "relationshipMethodName" => $this->makeBuilder([
                    RelationshipMethodName::class,
                    "${name}",
                ]),
                "relationshipName" => $this->makeBuilder([
                    RelationshipName::class,
                    'morphTo',
                ]),
                "relationshipArgs" => $this->makeBuilder([
                    RelationshipArgs::class,
                    "",
                ]),
                default => parent::getResolver($key, $keys),
            };
        } catch (Exception $e) {
            echo 'Unknown resolve key: ', $e->getMessage(), "\n";
        }
    }

    protected function getCorrespondingModels(): Resolver
    {
        $modelsStr = $this->getPropertyValue("morphModels");
        $modelsStr = explode(',', $modelsStr);

        $models = new ModelList($this->app);

        foreach($modelsStr as $modelStr) {
            $models->add($this->app->getModel(trim($modelStr)));
        }

        return $models;
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