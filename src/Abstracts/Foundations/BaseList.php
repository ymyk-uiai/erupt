<?php

namespace Erupt\Abstracts\Foundations;

use Erupt\Iterator;
use IteratorAggregate;
use Erupt\Interfaces\Foundations\BaseListItem;
use Erupt\Interfaces\Foundations\BaseList as BaseListInterface;

abstract class BaseList implements IteratorAggregate, BaseListInterface
{
    protected $list = [];

    public function getList()
    {
        return $this->list;
    }

    public function getIterator()
    {
        return new Iterator($this->list);
    }

    //  BaseListItem|BaseList $item
    protected function add($item)
    {
        if($item instanceof BaseListItem) {
            $this->addListItem($item);
        } else if($item instanceof BaseList) {
            foreach($item as $i) {
                $this->addListItem($i);
            }
        } else {
            //
        }
    }

    protected function remove($item)
    {
        if($item instanceof BaseListItem) {
            $this->removeListItemAt($this->indexOfListItem($item, 0));
        } else if($item instanceof BaseList) {
            foreach($item as $i) {
                $this->removeListItemAt($this->indexOfListItem($item, 0));
            }
        } else {
            //
        }
    }

    protected function addListItem(BaseListItem $listItem)
    {
        $this->list[] = $listItem;
    }

    protected function countListItem()
    {
        return count($this->list);
    }

    protected function getListItem($index)
    {
        if($index > -1 && $index < count($this->list)) {
            return $this->list[$index];
        } else {
            return false;
        }
    }

    protected function indexOfListItem(BaseListItem $listItem, $startIndex)
    {
        $index = $startIndex;

        while($index < count($this->list)) {
            if($listItem === $this->list[$index]) {
                return $index;
            }
            $index++;
        }

        return -1;
    }

    protected function removeListItemAt($index)
    {
        array_splice($this->list, $index, 1);
    }
}