<?php

namespace Erupt\Plans\Updaters;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class UnsignedBigIntegerUpdater extends AbstractUpdater
{
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function run(Property $property)
    {
        $property->setName($this->name);

        $property->setColumnType("UNSIGNED BIGINT");

        $property->setValueType("integer");
    }
}