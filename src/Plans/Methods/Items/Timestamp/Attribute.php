<?php

namespace Erupt\Plans\Methods\Items\Timestamp;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Timestamp\Updater as TimestampUpdater;

class Attribute extends BaseAttribute
{
    protected $name;

    protected $precision;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parse_params("name, precision?", $args);

        $product->set_name($params["name"]);

        $product->set_precision($params["precision"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_precision($precision)
    {
        $this->precision = $precision;
    }

    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = TimestampUpdater::build(["name" => $this->name, "precision" => $this->precision]);

        $updaterList->add($updater);

        return $updaterList;
    }
}