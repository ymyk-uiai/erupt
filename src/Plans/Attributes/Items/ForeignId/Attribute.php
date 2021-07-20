<?php

namespace Erupt\Plans\Attributes\Items\ForeignId;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Attributes\Items\UnsignedBigInteger\Attribute as UnsignedBigIntegerAttribute;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "name";

    public function getPropertyName(): string
    {
        return $this->args["name"];
    }
    protected string $migrationMethodName = "foreignId";

    public function evaluate()
    {
        $updaterList = new AttributeList;
        
        $a = new UnsignedBigIntegerAttribute(["name" => $this->args["name"]], $this->root);

        $u = $a->evaluate();

        $updaterList->add($u);

        return $updaterList;
    }
}