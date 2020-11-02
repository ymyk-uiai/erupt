<?php

namespace Erupt\Plans\Updaters;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class StringUpdater extends AbstractUpdater
{
    protected $name;

    protected $length;

    public static function build($args): Self
    {
        $product = new Self;

        $product->setName($args["name"]);

        $product->setLength($args["length"]);

        return $product;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }
    
    public function run(Property $property)
    {
        $property->setName($this->name);

        $property->setColumnType("VARCHAR");

        $property->setValueType("string");
    }
}