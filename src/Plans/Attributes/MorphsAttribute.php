<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\MorphsAttributeConstructor;
use Erupt\Plans\Containers\Updaters\UpdaterContainer;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Constructors\Attributes\UnsignedBigIntegerAttribute;
use Erupt\Plans\Constructors\Attributes\StringAttribute;

class MorphsAttribute extends AbstractAttribute
{
    protected $name;

    public function __construct()
    {
        //
    }

    public static function build($args): Self
    {
        return MorphsAttributeConstructor::build($args);
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function run()
    {
        $container = new UpdaterContainer;

        $l_1 = new UpdaterList;
        $l_2 = new UpdaterList;

        $container->add($l_1);
        $container->add($l_2);

        $m_1 = UnsignedBigIntegerAttribute::build(["name" => "{$this->name}_id"]);

        $m_2 = StringAttribute::build(["name" => "{$this->name}_type"]);

        $f_1 = $m_1->run();

        $f_2 = $m_2->run();

        $l_1->add($f_1);

        $l_2->add($f_2);

        return $container;
    }
}