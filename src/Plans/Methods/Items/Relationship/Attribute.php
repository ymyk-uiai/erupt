<?php

namespace Erupt\Plans\Methods\Items\Relationship;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Relationship\Updater as RelationshipUpdater;

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

        $updater = RelationshipUpdater::build();

        $updaterList->add($updater);

        return $updaterList;
    }
}