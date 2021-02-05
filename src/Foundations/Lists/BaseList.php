<?php

namespace Erupt\Foundations\Lists;

use IteratorAggregate;
use Erupt\Foundations\Lists\BaseIterator;
use Erupt\Foundations\Lists\BaseListItem;

abstract class BaseList implements IteratorAggregate
{
    protected array $list = [];

    public function get_list(): array
    {
        return $this->list;
    }

    public function getIterator()
    {
        return new BaseIterator($this->list);
    }

    //  BaseListItem|BaseList $item
    protected function add($item)
    {
        if($item instanceof BaseListItem) {
            $this->add_list_item($item);
        } else if($item instanceof BaseList) {
            foreach($item as $i) {
                $this->add_list_item($i);
            }
        } else {
            //
        }
    }

    protected function remove($item)
    {
        if($item instanceof BaseListItem) {
            $this->remove_list_item_at($this->index_of_list_item($item, 0));
        } else if($item instanceof BaseList) {
            foreach($item as $i) {
                $this->remove_list_item_at($this->index_of_list_item($item, 0));
            }
        } else {
            //
        }
    }

    protected function add_list_item(BaseListItem $list_item)
    {
        $this->list[] = $list_item;
    }

    protected function count_list_item()
    {
        return count($this->list);
    }

    protected function get_list_item($index)
    {
        if($index > -1 && $index < count($this->list)) {
            return $this->list[$index];
        } else {
            return false;
        }
    }

    protected function index_of_list_item(BaseListItem $list_item, $start_index)
    {
        $index = $start_index;

        while($index < count($this->list)) {
            if($list_item === $this->list[$index]) {
                return $index;
            }
            $index++;
        }

        return -1;
    }

    protected function remove_list_item_at($index)
    {
        array_splice($this->list, $index, 1);
    }
}