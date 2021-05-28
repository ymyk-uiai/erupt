<?php

namespace Erupt\Plans\Attributes\Items\Id;

use Erupt\Plans\Attributes\Items\BigIncrements\Attribute as BigIncrementsAttribute;
use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "";

    public function __construct(string|array $args)
    {
        $this->takeArgs($args);
    }
    public function evaluate()
    {
        $m = new BigIncrementsAttribute(["name" => "id"]);

        $fl = $m->evaluate();

        return $fl;
    }

    public function __toString()
    {
        return "id()";
    }
}