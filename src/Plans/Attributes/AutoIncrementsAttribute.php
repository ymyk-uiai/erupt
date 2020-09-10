<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Updaters\AutoIncrementsUpdater;

class AutoIncrementsAttribute extends AbstractAttribute
{
    public function __construct()
    {
        //
    }
    
    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = new AutoIncrementsUpdater;

        $updaterList->add($updater);

        return $updaterList;
    }
}