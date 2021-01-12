<?php

namespace Erupt\Plans\Tools\Required;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Tools\Required\Updater as RequiredUpdater;
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

        $updater = RequiredUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}