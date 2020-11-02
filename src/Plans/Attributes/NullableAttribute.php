<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Updaters\NullableUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class NullableAttribute extends AbstractAttribute
{
    public static function build(): Self
    {
        $product = new Self;

        return $product;
    }

    public function __construct()
    {
        //
    }
    
    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = NullableUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}