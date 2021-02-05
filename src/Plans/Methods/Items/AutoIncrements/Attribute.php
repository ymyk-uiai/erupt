<?php

namespace Erupt\Plans\Methods\Items\AutoIncrements;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\AutoIncrements\Updater as AutoIncrementsUpdater;

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

        $updater = AutoIncrementsUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}