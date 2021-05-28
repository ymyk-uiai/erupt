<?php

namespace Erupt\Foundations;

use IteratorAggregate;
use Erupt\Foundations\BaseIterator;
use Erupt\Foundations\BaseList;

abstract class BaseContainer implements IteratorAggregate
{
    protected array $container = [];

    public function getIterator()
    {
        return new BaseIterator($this->container);
    }

    protected function addListOrContainer(BaseList|Self $listOrContainer): void
    {
        if($listOrContainer instanceof Self) {
            foreach($listOrContainer as $list) {
                $this->addList($list);
            }
        } else {
            $this->addList($listOrContainer);
        }
    }

    protected function removeListOrContainer(BaseList|Self $listOrContainer): void
    {
        if($listOrContainer instanceof Self) {
            foreach($listOrContainer as $list) {
                $this->removeListAt($this->getIndexOf($list, 0));
            }
        } else {
            $this->removeListAt($this->getIndexOf($listOrContainer, 0));
        }
    }

    protected function addList(BaseList $list)
    {
        $this->container[] = $list;
    }


    protected function getIndexOf(BaseList $list, int $index): int
    {
        while($index < count($this->container)) {
            if($list === $this->container[$index]) {
                return $index;
            }
            $index++;
        }
        return -1;
    }

    protected function removeListAt(int $index): void
    {
        array_splice($this->container, $index, 1);
    }
}