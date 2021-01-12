<?php

namespace Erupt\Plans\Tools\ForeignId;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Tools\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;

class Attribute extends AbstractAttribute
{
    protected $name;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parseParams("name", $args);

        $product->setName($params["name"]);

        return $product;
    }

    public function __construct()
    {
        //
    }

    public function setName($name)
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