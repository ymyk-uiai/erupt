<?php

namespace Erupt\Plans\Methods\Items\Morphs;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Containers\UpdaterContainer;
use Erupt\Plans\Methods\Items\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;
use Erupt\Plans\Methods\Items\String\Attribute as StringAttribute;
use Erupt\Interfaces\SchemaMethod;

class Attribute extends BaseAttribute implements SchemaMethod
{
    protected $name;

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

    public function get_schema_method(): string
    {
        return "morphs('{$this->name}')";
    }
}