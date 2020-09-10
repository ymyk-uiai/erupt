<?php

namespace Erupt\Plans\Containers\Updaters;

use Erupt\Abstracts\Foundations\BaseListContainer;

class UpdaterContainer extends BaseListContainer
{
    public function add($updaterList)
    {
        parent::add($updaterList);
    }

    public function remove($updaterList)
    {
        parent::remove($updaterList);
    }

    public function count()
    {
        return parent::count();
    }
}