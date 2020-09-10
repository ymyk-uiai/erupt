<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\FillableAttributeConstructor;
use Erupt\Plans\Constructors\Updaters\FillableUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class FillableAttribute extends AbstractAttribute
{
    public function __construct()
    {
        //
    }

    public static function build(): Self
    {
        return FillableAttributeConstructor::build();
    }

    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = FillableUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}