<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\UnsignedBigIntegerAttribute as Constructor;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Constructors\Updaters\UnsignedBigIntegerUpdater;

class UnsignedBigIntegerAttribute extends AbstractAttribute
{
    protected $name;

    public function __construct()
    {
        //
    }

    public static function build(): Self
    {
        return Constructor::build();
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