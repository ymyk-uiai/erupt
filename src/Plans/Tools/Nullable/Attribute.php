<?php

namespace Erupt\Plans\Tools\Nullable;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Tools\Nullable\Updater as NullableUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class Attribute extends AbstractAttribute
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