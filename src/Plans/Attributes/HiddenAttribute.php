<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\HiddenAttributeConstructor;
use Erupt\Plans\Constructors\Updaters\HiddenUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class HiddenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        //
    }

    public static function build(): Self
    {
        return HiddenAttributeConstructor::build();
    }
    
    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = HiddenUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}