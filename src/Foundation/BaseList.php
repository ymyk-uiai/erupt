<?php

namespace Erupt\Foundation;

use IteratorAggregate;
use Erupt\Foundation\BaseIterator;
use Erupt\Foundation\BaseListItem;

abstract class BaseList implements IteratorAggregate
{
    protected array $items = [];

    public function takeOver(Self $list): void
    {
        foreach($list as $item) {
            $this->addItem($item);
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getIterator()
    {
        return new BaseIterator($this->items);
    }

    protected function addItemOrList(BaseListItem|Self $itemOrList): void
    {
        if($itemOrList instanceof Self) {
            foreach($itemOrList as $item) {
                $this->addItem($item);
            }
        } else {
            $this->addItem($itemOrList);
        }
    }

    protected function removeItemOrList(BaseListItem|Self $itemOrList): void
    {
        if($itemOrList instanceof Self) {
            foreach($itemOrList as $item) {
                $this->removeItemAt($this->getIndexOf($itemOrList, 0));
            }
        } else {
            $this->removeItemAt($this->getIndexOf($itemOrList, 0));
        }
    }

    protected function addItem(BaseListItem $item): void
    {
        $this->items[] = $item;
    }

    protected function getIndexOf(BaseListItem $item, $index): int
    {
        while($index < count($this->items)) {
            if($item === $this->items[$index]) {
                return $index;
            }
            $index++;
        }
        return -1;
    }

    protected function removeItemAt(int $index): void
    {
        array_splice($this->items, $index, 1);
    }
}