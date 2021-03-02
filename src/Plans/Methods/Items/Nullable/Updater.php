<?php

namespace Erupt\Plans\Methods\Items\Nullable;

use Erupt\Plans\Methods\BaseUpdater;
use Erupt\Models\Properties\Items\Property;
use Erupt\Models\ValidationRules\Items\IsRequiredRule;

class Updater extends BaseUpdater
{
    public static function build(): Self
    {
        $product = new Self;

        return $product;
    }

    public function run(Property $property): void
    {
        $property->get_validation_rules()->add(IsRequiredRule::build(false));
    }
}