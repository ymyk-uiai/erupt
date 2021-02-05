<?php

namespace Erupt\Plans\Methods\Items\Factory;

use Erupt\Plans\Methods\BaseUpdater;
use Erupt\Models\Properties\Items\Property;

class Updater extends BaseUpdater
{
    protected $name;

    protected $methods = [
        "email" => "safeEmail()",
    ];

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
        $property->set_factory($this->methods[$this->name]);
    }
}