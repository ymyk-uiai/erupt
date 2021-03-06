<?php

namespace Erupt\Plans\Attributes;

use Erupt\Traits\HasParams;
use Erupt\Foundations\BaseItem;
use Erupt\Plans\Attributes\Containers\AttributeContainer;
use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Attributes\BaseAttributeContainer;
use Erupt\Plans\Attributes\BaseAttributeList;
use ERupt\Plans\Attributes\BaseAttribute;

abstract class BaseAttribute extends BaseItem
{
    use HasParams;

    public function __construct(string|array $args = "")
    {
        $this->takeArgs($args);
    }

    abstract protected function evaluate();

    public function build(): BaseAttributeContainer
    {
        $product = $this->evaluate();

        if($product instanceof BaseAttributeContainer) {
            return $product;
        } else if($product instanceof BaseAttributeList) {
            $container = new AttributeContainer;
            $container->add($product);
            return $container;
        } else if($product instanceof BaseAttribute) {
            $list = new AttributeList;
            $container = new AttributeContainer;
            $container->add($list);
            $list->add($product);
            return $container;
        }
    }
}