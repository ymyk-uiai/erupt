<?php

namespace Erupt\Relationships\Updaters\Items;

use Erupt\Relationships\Updaters\Bases\BaseUpdater;
use Erupt\Models\Relationships\Bases\BaseRelationship as Relationship;

class RequiredUpdater extends Updater
{
    public function update(Relationship $relationship)
    {
        $relationship->set_flag("required", true);
    }
}