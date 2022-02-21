<?php

namespace Erupt\Factories;

use Erupt\Foundation\BaseList;

abstract class BaseFactoryList extends BaseList
{
    public function add(BaseFactory|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseFactory|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}