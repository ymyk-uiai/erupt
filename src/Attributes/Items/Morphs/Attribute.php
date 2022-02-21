<?php

namespace Erupt\Attributes\Items\Morphs;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name";

    protected string? $alias = "unsignedBigInteger:{name}_id&string:{name}_type";
}