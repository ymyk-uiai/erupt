<?php

namespace Erupt\Foundations;

use IteratorAggregate;
use Erupt\Foundations\BaseIterator;
use Erupt\Foundations\BaseItem;
use ReflectionClass;

abstract class NewBaseList implements IteratorAggregate
{
    protected array $list = [];

    abstract public function build(): void;

    abstract public function makeEmpty(): Self;

    public function copy(Self $list): void
    {
        foreach($list as $item) {
            $this->addItem($item);
        }
    }

    public function getIterator()
    {
        return new BaseIterator($this->list);
    }

    protected function addItemOrList(BaseItem|Self $itemOrList): void
    {
        if($itemOrList instanceof Self) {
            foreach($itemOrList as $item) {
                $this->addItem($item);
            }
        } else {
            $this->addItem($itemOrList);
        }
    }

    protected function removeItemOrList(BaseItem|Self $itemOrList): void
    {
        if($itemOrList instanceof Self) {
            foreach($itemOrList as $item) {
                $this->removeItemAt($this->getIndexOf($itemOrList, 0));
            }
        } else {
            $this->removeItemAt($this->getIndexOf($itemOrList, 0));
        }
    }

    protected function addItem(BaseItem $item): void
    {
        $this->list[] = $item;
    }

    protected function getIndexOf(BaseItem $item, $index): int
    {
        while($index < count($this->list)) {
            if($item === $this->list[$index]) {
                return $index;
            }
            $index++;
        }
        return -1;
    }

    protected function removeItemAt(int $index): void
    {
        array_splice($this->list, $index, 1);
    }
}