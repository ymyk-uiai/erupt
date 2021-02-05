<?php

namespace Erupt\Plans\Methods\Items\Casts;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Casts\Updater as CastsUpdater;

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

        $updater = CastsUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}