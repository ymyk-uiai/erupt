<?php

namespace Erupt\Relationships\Attributes;

use Erupt\Traits\HasList;
use Erupt\Relationships\Attributes\Items;
use IteratorAggregate;
use Erupt\Foundations\BaseIterator;

abstract class BaseAttributeList implements IteratorAggregate
{
    use HasList;

    public function getIterator()
    {
        return new BaseIterator($this->list);
    }


    public function __construct(array $attrs)
    {
        foreach($attrs as $attrName => $args) {
            $namespace = 'Erupt\Relationships\Attributes\Items';
            $className = $namespace.'\\'.ucfirst($attrName).'\Attribute';
            if(class_exists($className)) {
                $this->add(new $className($args));
            } else {
                $this->add(new Items\Flag\Attribute($attrName));
            }
        }
    }

    public function add(BaseAttribute|BaseAttributeList $item): void
    {
        if($item instanceof BaseAttributeList) {
            foreach($item as $i) {
                $this->addItem($i);
            }
        } else {
            $this->addItem($item);
        }
    }
}