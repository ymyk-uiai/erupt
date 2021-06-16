<?php

namespace Erupt\Plans\Properties;

use Erupt\Foundations\BaseList;
use Erupt\Plans\Properties\Items\Property;
use Erupt\Relationships\Relationships\Lists\RelationshipList;
use Erupt\Plans\Attributes\Lists\AttributeList;
use ReflectionClass;
use Erupt\Models\Models\Items\{User, Post, Folder, Comment};
use Exception;

abstract class BasePropertyList extends BaseList
{
    public static function empty(): Static
    {
        $reflection = new ReflectionClass(Static::class);
        return $reflection->newInstanceWithoutConstructor();
    }

    public function __construct(string $type, array $data, RelationshipList $relationships)
    {
        foreach($data["props"] as $prop) {
            $prop = $this->addDefaultAttributes($type, $prop);
            $this->add(new Property(new AttributeList($prop)));
        }

        $this->add($relationships->makeProps($type));
    }

    protected function addDefaultAttributes(string $modelType, string $planProp): string
    {
        $defaultAttributes = match ($modelType) {
            "user" => User::getDefaultAttributes($planProp),
            "post" => Post::getDefaultAttributes($planProp),
            "folder" => Folder::getDefaultAttributes($planProp),
            "comment" => Comment::getDefaultAttributes($planProp),
            default => throw new Exception("unknown model type"),
        };

        return implode('|', [$planProp, $defaultAttributes]);
    }

    public function add(BaseProperty|Self $prop): void
    {
        $this->addItemOrList($prop);
    }

    public function remove(BaseProperty|Self $prop): void
    {
        $this->removeItemOrList($prop);
    }
}