<?php

namespace Erupt\Plans\Attributes\Items\BigIncrements;

use Erupt\Plans\Attributes\Items\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;
use Erupt\Plans\Attributes\Items\AutoIncrements\Attribute as AutoIncrementsAttribute;
use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Plans\Attributes\Lists\AttributeList;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name";

    public function __construct(string|array $args)
    {
        $this->takeArgs($args);
    }

    public function evaluate()
    {
        $list = new AttributeList;

        $m_1 = new UnsignedBigIntegerAttribute(["name" => $this->name]);

        $m_2 = new AutoIncrementsAttribute();

        $f_1 = $m_1->evaluate();

        $f_2 = $m_2->evaluate();

        $list->add($f_1);

        $list->add($f_2);

        return $list;
    }

    public function __toString()
    {
        return "bigIncrement('{$this->name}')";
    }
}