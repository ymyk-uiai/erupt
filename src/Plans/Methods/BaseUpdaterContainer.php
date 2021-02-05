<?php

namespace Erupt\Plans\Methods;

use Erupt\Foundations\Lists\BaseListContainer;

abstract class BaseUpdaterContainer extends BaseListContainer
{
    //  Unit Type BaseUpdaterList|BaseUpdaterContainer
    public function add($updater)
    {
        parent::add($updater);
    }

    public function remove($updater)
    {
        parent::remove($updater);
    }
}