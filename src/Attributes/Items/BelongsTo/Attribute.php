<?php

namespace Erupt\Attributes\Items\BelongsTo;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "key";

    protected bool $column = true;
}