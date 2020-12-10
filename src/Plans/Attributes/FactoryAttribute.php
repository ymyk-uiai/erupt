<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Updaters\FactoryUpdater;
use Erupt\Plans\Lists\Updaters\UpdaterList;

class FactoryAttribute extends AbstractAttribute
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
        $updaterList = new UpdaterList;

        $updater = FactoryUpdater::build([ "name" => $this->name ]);

        $updaterList->add($updater);

        return $updaterList;
    }
}