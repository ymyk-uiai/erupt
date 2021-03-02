<?php

namespace Erupt\Plans\Methods\Items\Manual;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Manual\Updater as ManualUpdater;

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

        $updater = ManualUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}