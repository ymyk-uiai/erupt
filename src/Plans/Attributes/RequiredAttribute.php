<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Updaters\RequiredUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class RequiredAttribute extends AbstractAttribute
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