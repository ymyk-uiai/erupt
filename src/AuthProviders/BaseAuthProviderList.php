<?php

namespace Erupt\AuthProviders;

use Erupt\Foundation\BaseList;

abstract class BaseAuthProviderList extends BaseList
{
    public function get(): string
    {
        $result = [];
        foreach($this as $item) {
            $result[] = $item->get();
        }
        return implode("\n", $result);
    }

    public function add(BaseAuthProvider|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseAuthProvider|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}