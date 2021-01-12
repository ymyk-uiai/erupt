<?php

namespace Erupt\Plans\Tools\UnsignedBigInteger;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Tools\UnsignedBigInteger\Updater as UnsignedBigIntegerUpdater;

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
        $updater = UnsignedBigIntegerUpdater::build(["name" => $this->name]);

        return $updater;
    }
}