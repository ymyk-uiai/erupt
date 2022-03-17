<?php

namespace Erupt\Attributes\Items\HasMany;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "name";

    protected ?string $alias = "string:{name}_id";
}