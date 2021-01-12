<?php

namespace Erupt\Plans\Tools\Fillable;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Tools\Fillable\Updater as FillableUpdater;
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

        $updater = FillableUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}