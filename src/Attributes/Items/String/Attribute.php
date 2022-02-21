<?php

namespace Erupt\Attributes\Items\String;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name,length?";

    protected bool $column = true;

    protected string $values = "name:{name}|columnType:VARCHAR|valueType:string";

    protected ?string $schemaCommand = "string";
}