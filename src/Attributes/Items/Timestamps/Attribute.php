<?php

namespace Erupt\Attributes\Items\Timestamps;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "precision?";

    protected ?string $alias = "timestamp:created_at,{precision}|nullable&timestamp:updated_at,{precision}|nullable";

    protected ?string $schemaCommand = "timestamps";
}