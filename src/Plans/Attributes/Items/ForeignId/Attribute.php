<?php

namespace Erupt\Plans\Attributes\Items\ForeignId;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Attributes\Items\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name";

    public function evaluate()
    {
        $updaterList = new AttributeList;
        
        $a = new UnsignedBigIntegerAttribute(["name" => $this->name]);

        $u = $a->evaluate();

        $updaterList->add($u);

        return $updaterList;
    }

    public function __toString()
    {
        return "foreignId('{$this->name}')";
    }
}