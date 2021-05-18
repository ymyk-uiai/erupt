<?php

namespace Erupt\Plans\Methods\Items\UnsignedBigInteger;

use Erupt\Plans\Methods\BaseUpdater;
use Erupt\Models\Properties\BaseProperty as Property;

class Updater extends BaseUpdater
{
    protected $name;

    public static function build($args): Self
    {
        $product = new Self;

        $product->set_name($args["name"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function run(Property $property)
    {
        $property->set_name($this->name);

        $property->set_key($this->name);

        $property->set_column_type("UNSIGNED BIGINT");

        $property->set_value_type("integer");
    }
}