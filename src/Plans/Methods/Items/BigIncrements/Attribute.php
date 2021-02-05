<?php

namespace Erupt\Plans\Methods\Items\BigIncrements;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;
use Erupt\Plans\Methods\Items\AutoIncrements\Attribute as AutoIncrementsAttribute;

class Attribute extends BaseAttribute
{
    protected string $name;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parse_params("name, length?", $args);

        $product->set_name($params["name"]);

        return $product;
    }

    public function set_name($name)
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