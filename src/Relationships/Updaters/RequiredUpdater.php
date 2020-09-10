<?php

namespace Erupt\Relationships\Updaters;

use Erupt\Abstracts\Relationships\Updaters\Updater;
use Erupt\Models\Relationships\Relationship;

class RequiredUpdater extends Updater
{
    public function update(Relationship $relationship)
    {
        $relationship->setFlag("required", true);
    }
}