<?php

namespace Erupt\Plans\Attributes\Items\RememberToken;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Plans\Attributes\Items\String\Attribute as StringAttribute;
use Erupt\Plans\Attributes\Lists\AttributeList;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "";

    public function getPropertyName(): string
    {
        return "remember_token";
    }
    protected string $migrationMethodName = "rememberToken";

    public function evaluate()
    {
        $updaterList = new AttributeList;

        $a = new StringAttribute(["name" => "remember_token", "length" => 100], $this->root);

        $u = $a->evaluate();

        $updaterList->add($u);

        return $updaterList;
    }
}