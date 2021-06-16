<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Values\Items\RelationshipMethodName\Value as RelationshipMethodName;
use Erupt\Models\Values\Items\RelationshipName\Value as RelationshipName;
use Erupt\Models\Values\Items\RelationshipArgs\Value as RelationshipArgs;

class MorphOneToMany extends BaseProperty
{
    public function finish(string $propName): void
    {
        $name = $this->values->get('name');
        $name = preg_replace("/_[a-zA-Z0-9_]+$/", "", $name);
        $capName = ucfirst($name);

        if($this->getFlag('has')) {
            $this->values->update([
                new RelationshipMethodName("${name}s"),
                new RelationshipName('morphMany'),
                new RelationshipArgs("${capName}::class, '${name}able'"),
            ]);

            $this->getModel()->setFlag("${name}able", true);
        } else {
            $this->values->update([
                new RelationshipMethodName("${name}"),
                new RelationshipName('morphTo'),
                new RelationshipArgs(""),
            ]);

            if($this->values->getValue('columnType')->getValue() == 'UNSIGNED BIGINT') {
                $this->setFlag('hasRelationshipMethod', true);
                $this->setFlag("${name}", true);
            }
        }

        parent::finish($propName);
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        try {
            return match($key) {
                "model" => $this->getCorrespondingModel(),
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

    protected function getDefaultFlags(): array
    {
        return [
            'relationship' => true,
        ];
    }
}