<?php

namespace Erupt\Plans\Tools\Timestamp;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class Updater extends AbstractUpdater
{
    protected $name;

    protected $precision;

    public static function build($args): Self
    {
        $product = new Self;

        $product->setName($args["name"]);

        $product->setPrecision($args["precision"]);

        return $product;
    }

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