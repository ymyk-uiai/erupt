<?php

namespace Erupt\Plans\Properties;

use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Foundations\BaseItem;

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
}