<?php

namespace Erupt\Plans\Properties;

use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Foundations\BaseItem;
use Erupt\Interfaces\SchemaCommand;

abstract class BaseProperty extends BaseItem
{
    protected AttributeList $attributes;

    public function __construct(AttributeList $attributes)
    {
        $this->setAttributes($attributes);
    }

    public function setAttributes(AttributeList $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getAttributes(): AttributeList
    {
        return $this->attributes;
    }

    public function getName(): string
    {
        foreach($this->list as $item) {
            if($item instanceof SchemaCommand) {
                return $item->getPropertyName();
            }
        }

        return "name not found";
    }
}