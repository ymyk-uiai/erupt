<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Updaters\TimestampUpdater;

class TimestampAttribute extends AbstractAttribute
{
    protected $name;

    protected $precision;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parseParams("name, precision?", $args);

        $product->setName($params["name"]);

        $product->setPrecision($params["precision"]);

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

    public function setPrecision($precision)
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