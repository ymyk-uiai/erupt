<?php

namespace Erupt\Flags;

use Erupt\Foundation\BaseList;

abstract class BaseFlagList extends BaseList
{
    public function add(BaseFlag|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseFlag|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}