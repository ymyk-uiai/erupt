<?php

namespace Erupt\Plans\Methods\Items\Nullable;

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
        //  $property->setFlag("nullable", true);

        //  $property->setValidationRule("nullable", true);
    }
}