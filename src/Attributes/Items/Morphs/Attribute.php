<?php

namespace Erupt\Attributes\Items\Morphs;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "name";

    protected ?string $alias = "unsignedBigInteger:{name}_id||string:{name}_type";
}