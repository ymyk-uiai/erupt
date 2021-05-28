<?php

namespace Erupt\Plans\Plans;

use Erupt\Foundations\BaseItem;
use Erupt\Plans\Properties\Lists\PropertyList;
use Erupt\Models\Properties\Lists\PropertyList as ModelProps;

abstract class BasePlan extends BaseItem
{
    protected string $type;

    protected PropertyList $props;

    public function __construct(string $type, PropertyList $props)
    {
        $this->setType($type);

        $this->setProperties($props);
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setProperties(PropertyList $props)
    {
        $this->props = $props;
    }

    public function getProperties(): PropertyList
    {
        return $this->props;
    }

    public function getModelProps(): ModelProps
    {
        $props = ModelProps::empty();

        return $props;
    }
}