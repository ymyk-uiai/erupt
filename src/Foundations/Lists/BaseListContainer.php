<?php

namespace Erupt\Foundations\Lists;

use IteratorAggregate;
use Erupt\Foundations\Lists\BaseIterator;
use Erupt\Foundations\Lists\BaseList;

abstract class BaseListContainer implements IteratorAggregate
{
    protected array $container = [];

    public function getIterator()
    {
        return new BaseIterator($this->container);
    }

    protected function add($item)
    {
        if($item instanceof BaseList) {
            $this->add_list($item);
        } else if($item instanceof BaseListContainer) {
            foreach($item as $i) {
                $this->add_list($i);
            }
        } else {
            //
        }
    }

    protected function remove($item)
    {
        if($item instanceof BaseList) {
            $this->remove_list_at($this->index_of_list($item, 0));
        } else if($item instanceof BaseListContainer) {
            foreach($item as $i) {
                $this->remove_list_at($this->index_of_list($item, 0));
            }
        } else {
            //
        }
    }

    protected function count()
    {
        return $this->count_list();
    }

    protected function add_list(BaseList $list)
    {
        $this->container[] = $list;
    }

    protected function count_list()
    {
        return count($this->container);
    }

    protected function get_list($index)
    {
        if($index > -1 && $index < count($this->container)) {
            return $this->container[$index];
        } else {
            return false;
        }
    }

    protected function index_of_list(BaseList $list, $start_index)
    {
        $index = $start_index;

        while($index < count($this->container)) {
            if($list === $this->container[$index]) {
                return $index;
            }
            $index++;
        }

        return -1;
    }

    protected function remove_list_at($index)
    {
        array_splice($this->container, $index, 1);
    }
}