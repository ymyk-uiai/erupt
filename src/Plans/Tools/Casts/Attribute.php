<?php

namespace Erupt\Plans\Tools\Casts;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Tools\Casts\Updater as CastsUpdater;

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

        $updater = CastsUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}