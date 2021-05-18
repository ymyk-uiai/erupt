<?php

namespace Erupt\Plans\Methods\Items\Relationship;

use Erupt\Plans\Methods\BaseUpdater;
use Erupt\Models\Properties\BaseProperty;

class Updater extends BaseUpdater
{
    protected string $name;

    public static function build($args): Self
    {
        $product = new Self;

        $product->setArg("name", $args["name"]);

        return $product;
    }

    public function setArg(string $name, $value): void
    {
        $this->{$name} = $value;
    }

    public function run(BaseProperty $property)
    {
        $property->set_name($this->name);

        $property->set_key($this->name);

        $property->set_flag("relationship", true);
    }
}