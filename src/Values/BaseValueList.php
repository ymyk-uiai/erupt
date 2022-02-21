<?php

namespace Erupt\Values;

use Erupt\Foundation\BaseList;

abstract class BaseValueList extends BaseList
{
    public function add(BaseValue|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseValue|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}