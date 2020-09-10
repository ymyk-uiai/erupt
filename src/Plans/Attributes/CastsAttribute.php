<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\CastsAttributeConstructor;
use Erupt\Plans\Constructors\Updaters\CastsUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class CastsAttribute extends AbstractAttribute
{
    public function __construct()
    {
        //
    }

    public static function build(): Self
    {
        return CastsAttributeConstructor::build();
    }
    
    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = CastsUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}