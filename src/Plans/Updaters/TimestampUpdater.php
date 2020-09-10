<?php

namespace Erupt\Plans\Updaters;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class TimestampUpdater extends AbstractUpdater
{
    protected $name;

    protected $precision;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }
    
    public function run(Property $property)
    {
        $property->setName($this->name);

        $property->setColumnType("TIMESTAMP");

        $property->setValueType("string");
    }
}