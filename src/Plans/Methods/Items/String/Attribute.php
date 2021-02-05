<?php

namespace Erupt\Plans\Methods\Items\String;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\String\Updater as StringUpdater;

class Attribute extends BaseAttribute
{
    protected $name;

    protected $length;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parse_params("name, length?", $args);

        $product->set_name($params["name"]);

        $product->set_length($params["length"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_length($length)
    {
        $this->length = $length;
    }

    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = StringUpdater::build(["name" => $this->name, "length" => $this->length]);

        $updaterList->add($updater);

        return $updaterList;
    }
}