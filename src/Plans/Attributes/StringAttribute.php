<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Updaters\StringUpdater;

class StringAttribute extends AbstractAttribute
{
    protected $name;

    protected $length;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parseParams("name, length?", $args);

        $product->setName($params["name"]);

        $product->setLength($params["length"]);

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

    public function setLength($length)
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