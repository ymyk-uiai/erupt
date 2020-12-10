<?php

namespace Erupt\Plans\Updaters;

use Erupt\Abstracts\Plans\Updaters\Updater as AbstractUpdater;
use Erupt\Models\Properties\Property;

class FactoryUpdater extends AbstractUpdater
{
    protected $name;

    protected $methods = [
        "email" => "safeEmail()",
    ];

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
        $property->setFactory($this->methods[$this->name]);
    }
}