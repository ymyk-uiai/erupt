<?php

namespace Erupt\Plans\Attributes\Items\RememberToken;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Plans\Attributes\Items\String\Attribute as StringAttribute;
use Erupt\Plans\Attributes\Lists\AttributeList;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "";

    public function evaluate()
    {
        $updaterList = new AttributeList;

        $a = new StringAttribute(["name" => "remember_token", "length" => 100]);

        $u = $a->evaluate();

        $updaterList->add($u);

        return $updaterList;
    }

    public function __toString()
    {
        return "rememberToken()";
    }
}