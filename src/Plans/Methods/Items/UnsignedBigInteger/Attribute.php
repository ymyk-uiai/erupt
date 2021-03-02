<?php

namespace Erupt\Plans\Methods\Items\UnsignedBigInteger;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\UnsignedBigInteger\Updater as UnsignedBigIntegerUpdater;
use Erupt\Interfaces\SchemaMethod;

class Attribute extends BaseAttribute implements SchemaMethod
{
    protected $name;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parse_params("name", $args);

        $product->set_name($params["name"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }
    
    public function run()
    {
        $updater = UnsignedBigIntegerUpdater::build(["name" => $this->name]);

        return $updater;
    }

    public function get_schema_method(): string
    {
        return "unsignedBigInteger('{$this->name}')";
    }
}