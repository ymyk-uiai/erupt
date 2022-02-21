<?php

namespace Erupt\Attributes\Items\Id;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "";

    protected ?string $alias = "bigIncrements:id";

    protected ?string $schemaCommand = "id";
}