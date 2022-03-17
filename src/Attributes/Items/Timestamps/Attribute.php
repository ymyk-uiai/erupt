<?php

namespace Erupt\Attributes\Items\Timestamps;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "precision?";

    protected ?string $alias = "timestamp:created_at,{precision}|nullable||timestamp:updated_at,{precision}|nullable";
}