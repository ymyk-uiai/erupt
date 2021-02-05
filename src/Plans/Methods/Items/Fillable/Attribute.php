<?php

namespace Erupt\Plans\Methods\Items\Fillable;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Fillable\Updater as FillableUpdater;

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

        $updater = FillableUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}