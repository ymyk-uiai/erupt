<?php

namespace Erupt\Foundation;

use IteratorAggregate;
use Erupt\Foundation\BaseIterator;
use Erupt\Foundation\BaseList;

abstract class BaseListContainer implements IteratorAggregate
{
    protected array $lists = [];

    public function getIterator()
    {
        return new BaseIterator($this->lists);
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

    protected function addList(BaseList $list): void
    {
        $this->lists[] = $list;
    }


    protected function getIndexOf(BaseList $list, int $index): int
    {
        while($index < count($this->lists)) {
            if($list === $this->lists[$index]) {
                return $index;
            }
            $index++;
        }
        return -1;
    }

    protected function removeListAt(int $index): void
    {
        array_splice($this->lists, $index, 1);
    }
}