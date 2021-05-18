<?php

namespace Erupt\Plans\Methods\Items\String;

use Erupt\Plans\Methods\BaseUpdater;
use Erupt\Models\Properties\BaseProperty as Property;
use Erupt\Models\ValidationRules\Items\IsRequiredRule;

class Updater extends BaseUpdater
{
    protected $name;

    protected $length;

    public static function build($args): Self
    {
        $product = new Self;

        $product->set_name($args["name"]);

        $product->set_length($args["length"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_length($length)
    {
        $this->length = $length;
    }
    
    public function run(Property $property)
    {
        $property->set_name($this->name);

        $property->set_key($this->name);

        $property->set_column_type("VARCHAR");

        $property->set_value_type("string");

        $property->get_validation_rules()->add(IsRequiredRule::build(true));

        $property->set_factory("faker->sentence");
    }
}