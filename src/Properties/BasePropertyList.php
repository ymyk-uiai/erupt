<?php

namespace Erupt\Properties;

use Erupt\Foundation\BaseList;

abstract class BasePropertyList extends BaseList
{
    public function add(BaseProperty|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseProperty|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}