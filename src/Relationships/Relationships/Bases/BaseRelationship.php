<?php

namespace Erupt\Relationships\Relationships\Bases;

use Erupt\Abstracts\Foundations\BaseListItem;

class BaseRelationship extends BaseListItem
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getFlag(string $flagKey): bool
    {
        if(array_key_exists($flagKey, $this->flags)) {
            return $this->flags[$flagKey];
        } else {
            return false;
        }
    }
}