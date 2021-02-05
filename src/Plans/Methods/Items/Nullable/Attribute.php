<?php

namespace Erupt\Plans\Methods\Items\Nullable;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Nullable\Updater as NullableUpdater;

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

        $updater = NullableUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}