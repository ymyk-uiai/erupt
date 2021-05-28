<?php

namespace Erupt\Traits;

trait HasList
{
    protected array $list = [];

    protected function addItem($item): void
    {
        $this->list[] = $item;
    }

    protected function getItem($index)
    {
        if($index > -1 && $index < count($this->list)) {
            return $this->list[$index];
        } else {
            return false;
        }
    }

    protected function getIndexOfItem($item, int $start = 0): int
    {
        while($start < count($this->list)) {
            if($item === $this->list[$start]) {
                return $start;
            }
            $start++;
        }
        return -1;
    }

    protected function removeItemAt(int $index)
    {
        array_splice($this->list, $index, 1);
    }
}