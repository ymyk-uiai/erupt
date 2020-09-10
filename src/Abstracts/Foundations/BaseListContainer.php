<?php

namespace Erupt\Abstracts\Foundations;

use Erupt\Iterator;
use IteratorAggregate;
use Erupt\Interfaces\Foundations\BaseListContainer as ContainerInterface;
use Erupt\Interfaces\Foundations\BaseList;

abstract class BaseListContainer implements IteratorAggregate, ContainerInterface
{
    protected $container = [];

    public function getIterator()
    {
        return new Iterator($this->container);
    }

    protected function add($item)
    {
        if($item instanceof BaseList) {
            $this->addList($item);
        } else if($item instanceof BaseListContainer) {
            foreach($item as $i) {
                $this->addList($i);
            }
        } else {
            //
        }
    }

    protected function remove($item)
    {
        if($item instanceof BaseList) {
            $this->removeListAt($this->indexOfList($item, 0));
        } else if($item instanceof BaseListContainer) {
            foreach($item as $i) {
                $this->removeListAt($this->indexOfList($item, 0));
            }
        } else {
            //
        }
    }

    protected function count()
    {
        return $this->countList();
    }

    protected function addList(BaseList $list)
    {
        $this->container[] = $list;
    }

    protected function countList()
    {
        return count($this->container);
    }

    protected function getList($index)
    {
        if($index > -1 && $index < count($this->container)) {
            return $this->container[$index];
        } else {
            return false;
        }
    }

    protected function indexOfList(BaseList $list, $startIndex)
    {
        $index = $startIndex;

        while($index < count($this->container)) {
            if($list === $this->container[$index]) {
                return $index;
            }
            $index++;
        }

        return -1;
    }

    protected function removeListAt($index)
    {
        array_splice($this->container, $index, 1);
    }
}