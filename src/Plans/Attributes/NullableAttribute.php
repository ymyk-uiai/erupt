<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\NullableAttribute as Constructor;
use Erupt\Plans\Constructors\Updaters\NullableUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class NullableAttribute extends AbstractAttribute
{
    public function __construct()
    {
        //
    }

    public static function build(): Self
    {
        return Constructor::build();
    }
    
    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = NullableUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}