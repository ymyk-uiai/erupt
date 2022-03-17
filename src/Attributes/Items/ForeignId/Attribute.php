<?php

namespace Erupt\Attributes\Items\ForeignId;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "name";

    protected ?string $alias = "unsignedBigInteger:{name}_id";
}