<?php

namespace Erupt\Plans\Methods\Items\Factory;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Factory\Updater as FactoryUpdater;

class Attribute extends BaseAttribute
{
    protected string $name;

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
        $updaterList = new UpdaterList;

        $updater = FactoryUpdater::build([ "name" => $this->name ]);

        $updaterList->add($updater);

        return $updaterList;
    }
}