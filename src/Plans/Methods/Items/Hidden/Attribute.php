<?php

namespace Erupt\Plans\Methods\Items\Hidden;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Hidden\Updater as HiddenUpdater;

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

        $updater = HiddenUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}