<?php

namespace Erupt\Plans\Methods\Items\ForeignId;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;

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
        $a = UnsignedBigIntegerAttribute::build(["name" => $this->name]);

        $u = $a->run();

        return $u;
    }
}