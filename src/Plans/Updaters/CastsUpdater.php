<?php

namespace Erupt\Plans\Updaters;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class CastsUpdater extends AbstractUpdater
{
    public function run(Property $property)
    {
        $property->setFlag("casts", true);
    }
}