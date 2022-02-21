<?php

namespace Erupt\Routes;

use Erupt\Foundation\BaseList;

abstract class BaseRouteList extends BaseList
{
    public function get(): string
    {
        $result = [];
        foreach($this as $item) {
            $result[] = $item->get();
        }
        return implode("\n", $result);
    }

    public function add(BaseRoute|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseRoute|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}