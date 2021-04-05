<?php

namespace Erupt\Plans\Methods\Items\Rcontent;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Rcontent\Updater as RcontentUpdater;

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

        $updater = RcontentUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}