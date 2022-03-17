<?php

namespace Erupt\Attributes\Items\Timestamp;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "name,precision?";

    protected ?string $values = "name:{name}|columnType:TIMESTAMP|valueType:string";
}