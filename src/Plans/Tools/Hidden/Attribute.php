<?php

namespace Erupt\Plans\Tools\Hidden;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Tools\Hidden\Updater as HiddenUpdater;
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

        $updater = HiddenUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}