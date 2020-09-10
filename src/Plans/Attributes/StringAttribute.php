<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\StringAttribute as Constructor;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Constructors\Updaters\StringUpdater;

class StringAttribute extends AbstractAttribute
{
    protected $name;

    protected $length;

    public function __construct()
    {
        //
    }

    public static function build($args): Self
    {
        return Constructor::build($args);
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