<?php

namespace Erupt\Plans\Tools\UnsignedBigInteger;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class Updater extends AbstractUpdater
{
    protected $name;

    public static function build($args): Self
    {
        $product = new Self;

        $product->setName($args["name"]);

        return $product;
    }

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