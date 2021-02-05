<?php

namespace Erupt\Plans\Methods\Items\UnsignedBigInteger;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\UnsignedBigInteger\Updater as UnsignedBigIntegerUpdater;

class Attribute extends BaseAttribute
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
}