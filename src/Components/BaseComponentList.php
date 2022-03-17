<?php

namespace Erupt\Components;

use Erupt\Foundation\BaseList;

abstract class BaseComponentList extends BaseList
{
    public static function build(string $ps): static
    {
        $ps = explode('&', $ps);

        $primitiveList = new static;
        foreach($ps as $p) {
            $primitiveList->add(BaseComponent::build($p));
        }
        return $primitiveList;
    }

    public function __construct()
    {
        //
    }

    public function add(self|BaseComponent $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseComponent $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}