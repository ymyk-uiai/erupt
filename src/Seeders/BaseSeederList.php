<?php

namespace Erupt\Seeders;

use Erupt\Foundation\BaseList;

abstract class BaseSeederList extends BaseList
{
    public function get(): string
    {
        $result = [];
        foreach($this as $item) {
            $result[] = $item->get();
        }
        return implode("\n", $result);
    }

    public function add(BaseSeeder|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseSeeder|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}