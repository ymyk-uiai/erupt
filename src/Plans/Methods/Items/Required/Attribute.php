<?php

namespace Erupt\Plans\Methods\Items\Required;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Required\Updater as RequiredUpdater;

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

        $updater = RequiredUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}