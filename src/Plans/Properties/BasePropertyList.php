<?php

namespace Erupt\Plans\Properties;

use Erupt\Foundations\BaseList;
use Erupt\Plans\Properties\Items\Property;
use Erupt\Relationships\Relationships\Lists\RelationshipList;
use Erupt\Plans\Attributes\Lists\AttributeList;
use ReflectionClass;

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
            $this->add(new Property(new AttributeList($prop)));
        }

        $this->add($relationships->makeProps($type));
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