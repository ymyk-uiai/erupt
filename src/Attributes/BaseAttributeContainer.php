<?php

namespace Erupt\Attributes;

use Erupt\Foundation\BaseListContainer;
use Erupt\Attributes\Lists\AttributeList;
use Erupt\Properties\Lists\PropertyList;
use Erupt\Properties\BaseProperty;
use Erupt\Attributes\Containers\AttributeContainer;

abstract class BaseAttributeContainer extends BaseListContainer
{
    public function add(BaseAttributeList|Self $incoming): void
    {
        parent::addListOrContainer($incoming);
    }

    public function remove(BaseAttributeList|Self $incoming): void
    {
        parent::removeListOrContainer($incoming);
    }

    public function evaluate(): self
    {
        $container = new AttributeContainer;
        foreach($this as $list) {
            $container->add($list->evaluate());
        }
        return $container;
    }

    public function merge(self $container): void
    {
        foreach($container as $list) {
            if($list->hasColumn()) {
                $this->add($list);
            } else {
                foreach($this as $thisList) {
                    $thisList->add($list);
                }
            }
        }
    }

    public function makeProperties(): PropertyList
    {
        $props = new PropertyList;
        foreach($this as $list) {
            $props->add($this->makeProperty($list));
        }
        return $props;
    }

    abstract protected function makeCorrespondingProperty(): BaseProperty;

    protected function makeProperty(AttributeList $attrs): BaseProperty
    {
        $property = $this->makeCorrespondingProperty();
        foreach($attrs as $attr) {
            $property->build($attr);
        }
        return $property;
    }
}