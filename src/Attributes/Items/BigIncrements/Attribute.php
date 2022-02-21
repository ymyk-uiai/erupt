<?php

namespace Erupt\Attributes\Items\BigIncrements;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name";

    protected ?string $alias = "unsignedBigInteger:{name}|autoIncrements";
}