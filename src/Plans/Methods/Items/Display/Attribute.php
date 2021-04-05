<?php

namespace Erupt\Plans\Methods\Items\Display;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Display\Updater as DisplayUpdater;

class Attribute extends BaseAttribute
{
    public static function build(): Self
    {
        $product = new Self;

        return $product;
    }

    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = DisplayUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}