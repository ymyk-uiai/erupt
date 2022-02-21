<?php

namespace Erupt\Attributes\Items\Timestamp;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name,precision?";

    protected bool $column = true;

    protected string $values = "name:{name}|columnType:TIMESTAMP|valueType:string";
}