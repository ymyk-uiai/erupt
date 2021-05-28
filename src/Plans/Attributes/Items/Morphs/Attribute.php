<?php

namespace Erupt\Plans\Attributes\Items\Morphs;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Plans\Attributes\Containers\AttributeContainer;
use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Attributes\Items\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;
use Erupt\Plans\Attributes\Items\String\Attribute as StringAttribute;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name";

    public function evaluate()
    {
        $container = new AttributeContainer;

        $l_1 = new AttributeList;
        $l_2 = new AttributeList;

        $container->add($l_1);
        $container->add($l_2);

        $m_1 = new UnsignedBigIntegerAttribute(["name" => "{$this->name}_id"]);

        $m_2 = new StringAttribute(["name" => "{$this->name}_type"]);

        $f_1 = $m_1->evaluate();

        $f_2 = $m_2->evaluate();

        $l_1->add($f_1);

        $l_2->add($f_2);

        return $container;
    }

    public function __toString()
    {
        return "morphs('{$this->name}')";
    }
}