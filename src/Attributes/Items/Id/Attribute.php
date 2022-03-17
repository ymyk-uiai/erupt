<?php

namespace Erupt\Attributes\Items\Id;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "";

    protected ?string $alias = "bigIncrements:id";
}