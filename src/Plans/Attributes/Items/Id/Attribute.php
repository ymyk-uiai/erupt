<?php

namespace Erupt\Plans\Attributes\Items\Id;

use Erupt\Plans\Attributes\Items\BigIncrements\Attribute as BigIncrementsAttribute;
use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "";

    protected string $migrationMethodName = "id";

    public function getPropertyName(): string
    {
        return "id";
    }

    public function evaluate()
    {
        $m = new BigIncrementsAttribute(["name" => "id"], $this->root);

        $fl = $m->evaluate();

        return $fl;
    }
}