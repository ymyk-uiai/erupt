<?php

namespace Erupt\Plans\Tools\Required;

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
        $property->setValidationRules("required");
    }
}