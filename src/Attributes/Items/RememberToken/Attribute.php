<?php

namespace Erupt\Attributes\Items\RememberToken;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "";

    protected ?string $alias = "string:remember_token,100";
}