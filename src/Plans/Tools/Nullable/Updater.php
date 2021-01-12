<?php

namespace Erupt\Plans\Tools\Nullable;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class Updater extends AbstractUpdater
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