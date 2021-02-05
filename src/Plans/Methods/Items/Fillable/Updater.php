<?php

namespace Erupt\Plans\Methods\Items\Fillable;

use Erupt\Plans\Methods\BaseUpdater;
use Erupt\Models\Properties\Items\Property;

class Updater extends BaseUpdater
{
    public static function build(): Self
    {
        $product = new Self;

        return $product;
    }

    public function run(Property $property)
    {
        $property->set_flag("fillable", true);
    }
}