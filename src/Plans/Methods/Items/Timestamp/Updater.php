<?php

namespace Erupt\Plans\Methods\Items\Timestamp;

use Erupt\Plans\Methods\BaseUpdater;
use Erupt\Models\Properties\Items\Property;

class Updater extends BaseUpdater
{
    protected $name;

    protected $precision;

    public static function build($args): Self
    {
        $product = new Self;

        $product->set_name($args["name"]);

        $product->set_precision($args["precision"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_precision($precision)
    {
        $this->precision = $precision;
    }
    
    public function run(Property $property)
    {
        $property->set_name($this->name);

        $property->set_column_type("TIMESTAMP");

        $property->set_value_type("string");
    }
}