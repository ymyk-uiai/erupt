<?php

namespace Erupt\Plans\Methods;

use Erupt\Foundations\Lists\BaseList;

abstract class BaseUpdaterList extends BaseList
{
    //  Unit Type BaseUpdater|BaseUpdaterList
    public function add($updater)
    {
        parent::add($updater);
    }

    public function remove($updater)
    {
        parent::remove($updater);
    }
}