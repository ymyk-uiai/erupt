<?php

namespace Erupt\Events;

use Erupt\Foundation\BaseList;

abstract class BaseEventList extends BaseList
{
    public static function build(): self
    {
        return new static;
    }

    public function add(BaseEvent|self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseEvent|self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}