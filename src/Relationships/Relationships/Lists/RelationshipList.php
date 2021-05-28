<?php

namespace Erupt\Relationships\Relationships\Lists;

use Erupt\Relationships\Relationships\BaseRelationshipList;
use Erupt\Plans\Properties\Lists\PropertyList;

class RelationshipList extends BaseRelationshipList
{
    public function makeProps(string $type)
    {
        $props = PropertyList::empty();

        foreach($this->list as $relationship) {
            $props->add($relationship->makeProps($type));
        }

        return $props;
    }
}