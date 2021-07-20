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

    protected string $migrationMethodName = "bigIncrements";

    public function getPropertyName(): string
    {
        return $this->args["name"];
    }

    public function evaluate()
    {
        $list = new AttributeList;

        $m_1 = new UnsignedBigIntegerAttribute(["name" => $this->args["name"]], $this->root);

        $m_2 = new AutoIncrementsAttribute("", $this->root);

        $f_1 = $m_1->evaluate();

        $f_2 = $m_2->evaluate();

        $list->add($f_1);

        $list->add($f_2);

        return $list;
    }
}