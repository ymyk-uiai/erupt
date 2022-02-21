<?php

namespace Erupt\Attributes\Items\UnsignedBigInteger;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name";

    protected bool $column = true;

    protected string $values = "name:{name}|columnType:UNSIGNED BIGINT|valueType:integer";
}