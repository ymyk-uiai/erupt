<?php

namespace Erupt\Attributes\Items\ForeignId;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name";

    protected string? $alias = "unsignedBigInteger:{name}";
}