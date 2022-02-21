<?php

namespace Erupt\Attributes;

use Erupt\Foundation\BaseList;
use Erupt\Attributes\Containers\AttributeContainer;

abstract class BaseAttributeList extends BaseList
{
    public function add(BaseAttribute|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseAttribute|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }

    public function evaluate(): BaseAttributeContainer
    {
        $container = new AttributeContainer;
        foreach($this as $item) {
            $container->add($item->evaluate());
        }
        return $container;
    }

    public function hasColumn(): bool
    {
        foreach($this as $item) {
            if($item->isColumn()) {
                return true;
            }
        }
        return false;
    }
}