<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\BigIncrementsAttribute as Constructor;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Attributes\UnsignedBigIntegerAttribute;
use Erupt\Plans\Attributes\AutoIncrementsAttribute;

class BigIncrementsAttribute extends AbstractAttribute
{
    protected $name;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parseParams("name, length?", $args);

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
        $list = new UpdaterList;

        $m_1 = UnsignedBigIntegerAttribute::build(["name" => $this->name]);

        $m_2 = AutoIncrementsAttribute::build();

        $f_1 = $m_1->run();

        $f_2 = $m_2->run();

        $list->add($f_1);

        $list->add($f_2);

        return $list;
    }
}